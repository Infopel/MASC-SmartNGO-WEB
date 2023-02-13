<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Journals;
use App\Models\Projects;
use App\Models\JournalDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Helpers\AttachmentsHelper;

class NewsController extends Controller
{

    use AttachmentsHelper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newses = News::with('project')->get();

        // return $newses;
        return view('news.index', compact('newses'));
    }


    /**
     * Project News
     */
    public function project_news(Projects $project_identifier)
    {
        $newses = News::where('project_id', $project_identifier->id)->get();
        $project = $project_identifier;
        return view('news.index', compact('newses', 'project'));
    }

    /**
     * Project News
     */
    public function show_project_news(Projects $project_identifier, News $news)
    {
        $newses = News::where('project_id', $project_identifier->id)->get();
        // return $newses;
        return view('news.show_project_news', compact('news','newses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Projects $project_identifier = null)
    {
        $project = $project_identifier;
        return view('news.new', compact('project'));
    }

    /**
     * Create Project News
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Projects $project_identifier = null)
    {
        $request->validate([
            'news.title' => 'required|unique:news,title',
            'content.description' => 'required',
            'attachments.file' => "file|mimes:jpeg,png,gif,jpg,bmp,pdf,doc,docx,dotx,txt,xls,xlsx,xlc,csv,xml,mp4|max:204800000"
        ],[
            'required' => __('lang.errors.messages.required'),
            'unique' => __('lang.errors.messages.taken')
        ],[
            'news.title' => __('lang.field_title'),
            'content.description' => __('lang.field_description')
        ]);

        // return $request;
        // return $request->attachments['file']->getClientOriginalExtension();
        // return $this->file_data($request->attachments['file']);

        try {

            DB::beginTransaction();
            // Create new News Resource
            $news = new News();
            $news->project_id = $project_identifier->id ?? null;
            $news->title = $request->news['title'];
            $news->summary = $request->news['summary'];
            $news->description = $request->content['description'];
            $news->author_id = Auth::user()->id;
            $news->created_on = now();
            $news->save(); // Save data into database


            // check if the is an attachments
            if($request->attachments['file'] != null){
                $this->store_attachment($news->id, $request->attachments['file'], "News");
            }

            // Savar actividade no journal -> para notificar usuarios
            $journal = new Journals();
            $journal->journalized_id = $news->id;
            $journal->journalized_type = "News";
            $journal->user_id = Auth::user()->id;;
            $journal->notes = __('lang.jouranl_news_poject_created', ['project' => $project_identifier->name ?? null]);
            $journal->created_on = now();
            $journal->private_notes = false;
            $journal->save(); // Save data into database

            DB::commit();

            if($project_identifier == null){
                return redirect()->route('news.show', ['news' => $news->id])->with('success', __('lang.notice_successful_create'));
            }else{
                return redirect()->route('projects.news', ['project_identifier' => $project_identifier->identifier])->with('success', __('lang.notice_successful_create'));
            }

        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
            return redirect()->route('projects.store', ['project_identifier' => $project_identifier->identifier])->with('error', __('lang.errors.unknown' . ' ' . $th->getMessage()));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        $newses = News::with('project')->get();
        $news->project;
        $news->attachments;

        // return $news;
        return view('news.show', compact('news', 'newses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(Projects $project_identifier , News $news)
    {
        $news->attachments;

        // return $news;
        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        // return $request;
        $request->validate([
            'news.title' => 'required',
            'content.description' => 'required',
            'attachments.file' => "file|mimes:jpeg,png,gif,jpg,bmp,pdf,doc,docx,dotx,txt,xls,xlsx,xlc,csv,xml,mp4|max:204800000"
        ], [
            'required' => __('lang.errors.messages.required'),
            'unique' => __('lang.errors.messages.taken')
        ], [
            'news.title' => __('lang.field_title'),
            'content.description' => __('lang.field_description')
        ]);

        try {

            DB::beginTransaction();
            // check if the is an attachments
            if ($request->attachments['file'] != null) {
                $this->store_attachment($news->id, $request->attachments['file'], "News");
            }
            // Journals
            if($news->title !== $request->news['title']){
                $this->jornalize_news_changes($news, $request->news['title'], 'title');
            }
            if($news->summary !== $request->news['summary']){
                $this->jornalize_news_changes($news, $request->news['summary'], 'summary');
            }
            if($news->description !== $request->content['description']){
                $this->jornalize_news_changes($news, $request->content['description'], 'description');
            }
            // Create new News Resource
            $news->title = $request->news['title'];
            $news->summary = $request->news['summary'];
            $news->description = $request->content['description'];
            $news->update(); // Save data into database

            DB::commit();
            return back()->with('success', __('lang.notice_successful_create'));
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollback();
            return back()->with('error', __('lang.errors.unknown => '.$th->getMessage()));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        //
    }

    public function jornalize_news_changes($news, $new_value, $property)
    {
        // Savar actividade no journal -> para notificar usuarios
        $journal = new Journals();
        $journal->journalized_id = $news->id;
        $journal->journalized_type = "News";
        $journal->user_id = Auth::user()->id;;
        $journal->notes = __( \ucfirst($property).' da notícia'.$news->title.' foi alterado(a).', ['project' => $news->project_id ?? null]);
        $journal->created_on = now();
        $journal->private_notes = false;
        $journal->save(); // Save data into database

        $journal_details = new JournalDetails();
        $journal_details->journal_id = $journal->id;
        $journal_details->property = $property;
        $journal_details->prop_key = 'news';
        $journal_details->old_value = $news[$property];
        $journal_details->value = $new_value;
        $journal_details->save(); // Save data into database
    }
}
