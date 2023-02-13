<?php

namespace App\Http\Controllers\Helpers;

use App\Models\Issues;
use App\Models\Members;
use App\Models\Projects;
use App\Models\Trackers;
use App\Models\CustomFields;
use App\Models\Enumerations;
use App\Models\ProjectTrackers;
use App\Models\CustomFieldsTrackers;
use App\Models\CustomValues;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Helpers\CustomFieldsHelper;
use App\Models\IndicatorFieldsIssues;
use App\Models\IndicatorFieldsValues;
use App\Models\Watchers;
use Illuminate\Http\Request;

trait IssuesHelper
{
    use CustomFieldsHelper;

    protected $query;
    protected $issue_subject;
    protected $issue_id;
    /**
     * Search Parent
     */

    public function search_parent($query, $issue_id = null, $issue_subject = null, $project_id)
    {
        $this->query = $query;
        $this->issue_id = $issue_id;
        $this->issue_subject = $issue_subject;

        if ($issue_id == null && $issue_subject == null) {
            return Issues::where(function ($q) {
                $q->where('subject', 'like', '%' . $this->query . '%')->orWhere('id', 'like', '%' . $this->query . '%');
            })->where('project_id', $project_id)->limit(10)->get()->toArray();
        } else {
            return Issues::where(function ($q) {
                $q->where('subject', 'like', '%' . $this->query . '%')->orWhere('id', 'like', '%' . $this->query . '%');
            })->where(function ($q) {
                $q->where('subject', 'not like', '%' . $this->issue_subject . '%')->orWhere('id', 'not like', '%' . $this->issue_id . '%');
            })->where('project_id', $project_id)->limit(10)->get()->toArray();
        }
    }


    /**
     * Return issues types
     */
    public function trackers()
    {
        return Trackers::where('id', 'name', 'core_fields')->get();
    }

    /**
     * Return list of project members
     */
    public function member_projects($project_id)
    {
        return Members::where('project_id', $project_id)
            ->with('user')
            ->has('user')
            ->get()
            ->toArray();
    }

    /**
     * issues priorities
     */
    public function issues_priorities()
    {
        return Enumerations::where('type', 'IssuePriority')->orderby('position', 'asc')->get()->toArray();
    }

    /**
     * Return issues project trackers
     */
    public function isses_project_trackers($project_id)
    {
        $project = Projects::where('id', $project_id)->with('project_trackers')->first()->toArray();
        $this->isLoading = false;

        return $project['project_trackers'];
    }

    /**
     * Get tracker core_fields
     */
    public function tracker_core_fields($tracker_id = null)
    {
        if ($tracker_id == null) {
            $tracker = Trackers::orderby('position', 'asc')
                ->with('default_status')
                ->first()->toArray();
            $this->isLoading = false;
            return array(
                'core_fields' => Yaml::parse($tracker['core_fields']),
                'default_status' => $tracker['default_status'],
                'tracker_custom_fields' => $this->tracker_custom_fields($tracker['id'])
            );
        } else {
            $tracker = Trackers::where('id', $tracker_id)
                ->orderby('position', 'asc')
                ->with('default_status')
                ->first()->toArray();
            $this->isLoading = false;

            return array(
                'core_fields' => Yaml::parse($tracker['core_fields']),
                'default_status' => $tracker['default_status'],

            );
        }
    }

    /**
     * Get Tracker custom_fields
     */
    public function tracker_custom_fields($tracker_id = 1)
    {
        $tracker_custom_fields = CustomFieldsTrackers::where('tracker_id', $tracker_id)->with('custom_field')->get()->toArray();
        $_custom_fields = [];
        foreach ($tracker_custom_fields as $key => $custom_fields) {
            $_custom_fields[] = $custom_fields['custom_field'];
        }
        $custom_fields = $this->custom_field_tag_with_label(null, [], $_custom_fields);
        // return $tracker_custom_fields;
        return $custom_fields;
    }

    /**
     * Get Tracker custom_fields
     */
    public function tracker_custom_fields_with_labels($tracker_id, $issue = [])
    {
        $tracker_custom_fields = CustomFieldsTrackers::where('tracker_id', $tracker_id)->with('custom_field')->get()->toArray();
        $_custom_fields = [];
        foreach ($tracker_custom_fields as $key => $custom_fields) {
            $_custom_fields[] = $custom_fields['custom_field'];
        }
        $custom_fields = $this->custom_field_tag_with_label($issue['id'], $issue['custom_field_values'], $_custom_fields);
        return $custom_fields;
    }


    /**
     * delete request
     */

    public function delete_request(Issues $issue)
    {
        if ($issue->childs->count() > 0) {
            return back()->with('error', __('lang.error_can_not_delete_issue'));
        }
        // return $issue;
        return back()->with('isRemoveTrue', [
            'msg' => __('lang.text_are_you_sure'),
            'issue_subject' => $issue['subject'],
            'issue_id' => $issue->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Issues  $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issues $issue)
    {
        // return $issue;

        $project_identifier = $issue->project->identifier;
        try {
            DB::beginTransaction();

            CustomValues::where('customized_type', 'Issue')->where('customized_id', $issue->id)->delete();
            IndicatorFieldsIssues::where('issue_id', $issue->id)->delete();
            IndicatorFieldsValues::where('customized_id', $issue->id)->where('indicator_type', 'Issue')->delete();
            Watchers::where('watchable_id', $issue->id)->where('watchable_type', 'Issue')->delete();
            $issue->delete();

            DB::commit();

            return redirect()->route('projects.issues.tracking', ['project_identifier' => $project_identifier])->with('success', __('lang.notice_successful_delete'));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Ocorreu um erro! Tarefa não removida.');
        }
    }
}
