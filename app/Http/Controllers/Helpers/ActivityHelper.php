<?php

namespace App\Http\Controllers\Helpers;

trait ActivityHelper
{
    /**
     * generate_activities_history_time
     */
    public function generate_activities_history_time($activitie)
    {
        $activitie_issues = [];
        foreach ($activitie as $activity) {
            $_created_date = ucwords(\Carbon\Carbon::parse($activity->updated_on)->formatLocalized('%d %B %Y'));
            if ($activity->created_on == $activity->updated_on) {
                $activity->isUpdated = false;
                $activity->_time = \Carbon\Carbon::parse($activity->created_on)->diffForHumans();
            } else {
                $activity->isUpdated = true;
                $activity->_time = \Carbon\Carbon::parse($activity->updated_on)->diffForHumans();
            }
            $activitie_issues[$_created_date][] = $activity;
        }

        return $activitie_issues;
    }
}
