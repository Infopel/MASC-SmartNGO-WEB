<?php

namespace App\Http\Controllers\Helpers;

use App\Models\Trackers;
use App\Models\ProjectTrackers;

trait TrackersHelper
{

    protected function default_trackers_pde()
    {
        return array(
            1, 3, 4, 5, 8
        );
    }

    protected function default_trackers_project()
    {

        $default_trackers_project  = [];

        try {
            $trackers = Trackers::select('id')->where('is_in_roadmap', true)->get();

            foreach ($trackers as $key => $tracker) {
                $default_trackers_project[] = $tracker->id;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        if (sizeof($default_trackers_project) > 0) {
            return $default_trackers_project;
        }

        return array(
            1, 3, 4, 5, 14
        );
    }

    /**
     * Store default tracker on project creation
     */
    public function add_default_tracker($project_id, $type = "PDE")
    {
        if ($type == "PDE") {
            try {
                foreach ($this->default_trackers_pde() as $tracker) {
                    $project_tracker = new ProjectTrackers();
                    $project_tracker->project_id = $project_id;
                    $project_tracker->tracker_id = $tracker;
                    $project_tracker->save(); // Save data into database
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        } else {
            try {
                foreach ($this->default_trackers_project() as $tracker) {
                    $project_tracker = new ProjectTrackers();
                    $project_tracker->project_id = $project_id;
                    $project_tracker->tracker_id = $tracker;
                    $project_tracker->save(); // Save data into database
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }
}
