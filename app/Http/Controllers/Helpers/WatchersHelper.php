<?php

namespace App\Http\Controllers\Helpers;

use App\Models\Watchers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait WatchersHelper
{
    /**
     * Add Self whatcher
     */
    public function self_watcher(int $watchable_id, string $watchable_type)
    {
        // if (!auth()->user()->can('add_issues', [Issues::class, $project_identifier['id']])) {
        //     return abort(401);
        // }

        // Check is the user is whatching this.
        $watcher = Watchers::where('watchable_type', $watchable_type)->where('watchable_id', $watchable_id)->where('user_id', auth()->user()->id)->first();

        if($watcher){
            Watchers::where('watchable_type', $watchable_type)->where('watchable_id', $watchable_id)->where('id', $watcher->id)->delete();
            return back();
        }else{
            try {
                DB::beginTransaction();
                // Remove is avalible whatcher
                $new_watcher = new Watchers();
                $new_watcher->watchable_type = $watchable_type;
                $new_watcher->watchable_id = $watchable_id;
                $new_watcher->user_id = auth()->user()->id;
                $new_watcher->save(); // Save data into database
                DB::commit();
                return back();
            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }
        }


    }

    /**
     * Add whatchers
     */
    public function add_watchers(Request $request, int $watchable_id, string $watchable_type)
    {
        return $request;
    }
}
