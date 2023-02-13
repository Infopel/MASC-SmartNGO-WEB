<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class Assiduidade extends Component
{
    public $AssiduidadeData = [];
    public $AssiduidadeDa = [];


    public function render()
    {
        return view('livewire.assiduidade');
    }

    public function mount()
    {
        $this->loadIssues();
    }

    public function loadIssues()
    {
        $results = User::where('type','user')->where('last_login_on','!=',null)->orderBy('last_login_on','DESC')->take(10)->get();

        $this->AssiduidadeData = $results;

        $result = User::where('type','user')->where('last_login_on','!=',null)->orderBy('last_login_on','ASC')->latest('last_login_on')->take(10)->get();

        $this->AssiduidadeDa = $result;

    }
}
