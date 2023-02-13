<?php

namespace App\Http\Controllers;

use App\Models\Journals;
use App\Models\Projects;
use App\Models\Documents;
use App\Models\Attachments;
use App\Models\Enumerations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Helpers\AttachmentsHelper;

class DocumentsController extends Controller
{
    use AttachmentsHelper;

    protected $type = 'DocumentCategory';

    /**
     * Show Documents list for specfic project
     */
    public function project_documents(Projects $project_identifier)
    {
        $project = $project_identifier;
        $documents = array();
        foreach ($project->documents()->get() as  $_document) {
            $category = \str_replace(' ', '-', $_document->category['name']);
            // $category = \mb_strtolower($category, 'UTF-8');
            $documents[$category][] = $_document;
        }

        $project->documents = $documents;
        // return $project;


        return view('documents.index', compact('project'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Enumerations::where('type', $this->type)->orderby('position', 'asc')->get();

        return view('documents.new', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Projects $project_identifier)
    {

        // return $request->attachments['file'];
        $request->validate([
            'documents.title' => 'required|unique:news,title',
            'documents.category' => 'required',
            'content.description' => 'required',
            'attachments.file' => "file|mimes:jpeg,png,gif,jpg,bmp,pdf,doc,docx,dotx,txt,xls,xlsx,xlc,csv,xml,mp4|max:204800000"
        ], [
            'required' => __('lang.errors.messages.required'),
            'unique' => __('lang.errors.messages.taken')
        ], [
            'documents.title' => __('lang.field_title'),
            'documents.category' => __('lang.field_category'),
            'content.description' => __('lang.field_description')
        ]);

        // return $request;

        try {
            DB::beginTransaction();

            // Create new Documents Resource
            $document = new Documents();
            $document->title = $request->documents['title'];
            $document->description = $request->content['description'];
            $document->project_id = $project_identifier->id;
            $document->category_id = $request->documents['category'];
            $document->created_on = now();
            $document->save(); // Save data into database

            // check if the is an attachments
            if ($request->attachments['file'] != null) {
                $this->store_attachment($document->id, $request->attachments['file'], "Documents");
            }

            // Savar actividade no journal -> para notificar usuarios
            $journal = new Journals();
            $journal->journalized_id = $document->id;
            $journal->journalized_type = "Documents";
            $journal->user_id = Auth::user()->id;;
            $journal->notes = __('Novo Documento cadastro e associado ao projecto :project', ['project' => $project_identifier->name ?? null]);
            $journal->created_on = now();
            $journal->private_notes = false;
            $journal->save(); // Save data into database

            DB::commit();

            return redirect()->route('projects.documents', ['project_identifier' => $project_identifier->identifier])
                ->with('success', __('lang.notice_successful_create'));
        }catch(\Throwable $th){
            DB::rollback();
            throw $th;
            return back()->with('error', __('lang.errors.unknown' . ' ' . $th->getMessage()));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Documents  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Documents $document)
    {
        $document->attachments;
        $document->project;
        $document->category;

        // return $document;

        return view('documents.show', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmailAddresses  $emailAddresses
     * @return \Illuminate\Http\Response
     */
    public function edit(Documents $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Documents  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Documents $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Documents  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Documents $document)
    {
        //
    }

}
