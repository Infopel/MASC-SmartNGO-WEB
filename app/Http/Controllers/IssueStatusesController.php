<?php

namespace App\Http\Controllers;

use App\Models\Issues;
use App\Models\IssueStatuses;
use Illuminate\Http\Request;

class IssueStatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $issues_status = IssueStatuses::select('*')->orderby('position', 'asc')->get();

        $data = array(
            'issues_status' => $issues_status
        );
        // return $data;
        return view('issue_statuses.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'issues_status' => []
        );
        // return $data;
        return view('issue_statuses.new', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "issues_status.name" => 'required|unique:issue_statuses,name'
        ]);

        $i_status = IssueStatuses::select('position')->orderby('position', 'desc')->first()['position'];
        $position = $i_status ?? 0;

        $issueStatuses = new IssueStatuses();
        $issueStatuses->name = $request->issues_status['name'];
        $issueStatuses->is_closed = $request->issues_status['is_closed'];
        $issueStatuses->position = ++$position;
        $issueStatuses->default_done_ratio = null;

        try {
            $issueStatuses->save();
            return back()->with('status', __('lang.notice_successful_create'));
        } catch (\Throwable $th) {
            return back()->with('erros', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IssueStatuses  $issueStatuses
     * @return \Illuminate\Http\Response
     */
    public function show(IssueStatuses $issueStatuses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IssueStatuses  $issueStatuses
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $issues_status = IssueStatuses::select('*')->where('id', $id)->orderby('position', 'asc')->firstOrFail();;

        $data = array(
            'issues_status' => $issues_status
        );
        // return $data;
        return view('issue_statuses.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IssueStatuses  $issueStatuses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            "issues_status.name" => 'required'
        ]);

        $issueStatuses = IssueStatuses::where('id', $id)->firstOrFail();

        $i_status['name'] = $request->issues_status['name'];
        $i_status['is_closed'] = $request->issues_status['is_closed'] == 1 ? 1 : 0;

        try {
            if ($issueStatuses->name !== $request->issues_status['name'] || $issueStatuses->is_closed !== $request->issues_status['is_closed']) {
                $issueStatuses->update($i_status);
            }
            return back()->with('status', __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            return back()->with('erros', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IssueStatuses  $issueStatuses
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // error_can_not_delete_tracker
        // error_can_not_delete_custom_field
        // error_can_not_remove_role
        $issueStatuses = IssueStatuses::where('id', $id)->firstOrFail();
        if (Issues::where('status_id', $id)->first()) {
            return back()->with('erros', __('lang.error_unable_delete_issue_status'));
        }
        try {
            $issueStatuses->delete();
            return back()->with('status', __('lang.notice_successful_delete'));
        } catch (\Throwable $th) {
            return back()->with('erros', $th->getMessage());
        }
    }
}
