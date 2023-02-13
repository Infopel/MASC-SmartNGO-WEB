<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Watchers extends Component
{

    public $users;
    public $search_user;
    public $watchers;
    public $project;
    public $issue_id;
    public $selected_users = [];
    public $showModal = false;


    public $avalible_watchers = [];

    public function mount($watchers, $project, $issue_id)
    {
        $this->issue_id = $issue_id;
        $this->watchers = $watchers;
        $this->project = $project;
        $this->avalible_watchers();
    }

    public function render()
    {
        return view('livewire.watchers');
    }


    /**
     * Set AvalibleWatchers
     */
    public function avalible_watchers()
    {
        foreach ($this->watchers as $key => $watcher) {
            $this->avalible_watchers[] = $watcher->user->id;
        }
        return $this->avalible_watchers;
    }

    /**
     * Add users as watchers
     */
    public function add_watchers()
    {
        if($this->selected_users == []){
            return;
        }
        foreach ($this->selected_users as $key => $user_id) {
            // dd($this->issue_id);
            try {
                $watcher = new \App\Models\Watchers();
                $watcher->watchable_type = 'Issue';
                $watcher->watchable_id = $this->issue_id;
                $watcher->user_id = $user_id;

                $watcher->save(); // Save data into database
                $this->watchers = \App\Models\Watchers::with('user')->where('watchable_type', 'Issue')->where('watchable_id', $this->issue_id)->get();

                $this->showModal = false;
                $this->selected_users = [];
                $this->avalible_watchers = [Auth::user()->id];
                $this->avalible_watchers();
            } catch (\Throwable $th) {
                //throw $th;
                return back()->with('error', ' Ocorreu um erro no cadastro de observadores');
            }
        }
    }

    /**
     * Remove user as watcher
     */
    public function removeWatcher($id)
    {
        $watcher = \App\Models\Watchers::find($id);
        $watcher->delete();

        $this->selected_users = [];
        $this->avalible_watchers = [Auth::user()->id];
        $this->watchers = \App\Models\Watchers::with('user')->where('watchable_type', 'Issue')->where('watchable_id', $this->issue_id)->get();
        $this->avalible_watchers();
    }


    /**
     * Search user
     */
    public function updatedSearchUser()
    {
        $this->users = User::where('status', true)
            ->where('type', 'User')
            ->whereNotIn('id', $this->avalible_watchers)
            ->where(function($q){
                $q->where('lastname', 'like', '%'.$this->search_user .'%')->orWhere('firstname', 'like', '%'.$this->search_user .'%');
            })
            ->get();
    }

    /**
     * Close list User modal
     */
    public function showModal()
    {
        $this->search_user = null;
        $this->showModal = true;
        $this->avalible_watchers = [Auth::user()->id];
        $this->avalible_watchers();
        $this->users = User::where('status', true)->where('type', 'User')->whereNotIn('id', $this->avalible_watchers)->get();
    }

    /**
     * Close list User modal
     */
    public function closeModal()
    {
        $this->search_user = null;
        $this->showModal = false;
        $this->selected_users = [];
    }
}
