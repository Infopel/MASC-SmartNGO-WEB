<?php

namespace App\Http\Controllers;

use App\Models\Issues;
use App\Models\Projects;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events_issues = Issues::where('is_aproved', true)->get();
        $events = $this->generate_events($events_issues);
        // $events = json_encode($events);
        return view('calendar.index', compact('events'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Issues  $issues
     * @return \Illuminate\Http\Response
     */
    public function show(Projects $project_identifier)
    {
        $project = $project_identifier;
        $events_issues = Issues::where('is_aproved', true)->where('project_id', $project->id)->get();
        $events = $this->generate_events($events_issues);
        // return $events;

        return view('calendar.show', compact('events'));
    }

    /**
     * Retornar os eventos/Tarefas disponivel - para add no calendario
     *
     * @return \Illuminate\Http\Response
     */
    public function calendar_events()
    {
        //
    }


    protected function generate_events($events_issues)
    {
        $events = [];
        foreach ($events_issues as $event) {
            $events[] = array(
                'id' => $event->id,
                // 'startDate' => \Carbon\Carbon::parse($event->start_date)->format('Y-m-d H:i:s'),
                // 'endDate' => \Carbon\Carbon::parse($event->due_date)->format('Y-m-d H:i:s'),
                'startDate' => date('Y-m-d H:m', strtotime($event->start_date)),
                'endDate' => null,
                'due_date' => date('Y-m-d H:m', strtotime($event->due_date)),
                'title' => $event->subject,
                'url' => $event->url_route(),
                'desc' => $event->description,
                'tracker' => $event->tracker->name,
            );
        }
        return $events;
    }

}
