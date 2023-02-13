<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Issues;

class Reportar extends Component
{
    public $IssuesData = [];

    public function render()
    {
        return view('livewire.reportar');
    }


    public function mount()
    {
        $this->loadIssues();
    }

    public function loadIssues()
    {
        $results = Issues::where('is_aproved', 0)->where('due_date','<=','2021-04-01')
                            ->join('Users', 'Users.id', '=', 'Issues.author_id')
                            ->get();

        $this->IssuesData = $results;

    }
}
