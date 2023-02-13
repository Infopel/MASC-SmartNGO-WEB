<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SystemInfoUpdateModalComponent extends Component
{
    public $with_form;
    public $show_notification;
    public $issue;

    /**
     * Mounting Component
     */
    public function mount($issue = [], $show_notification = false, $with_form = false)
    {
        $this->issue = $issue;
        $this->show_notification = $show_notification;
        $this->with_form = $with_form;
    }

    public function render()
    {
        return view('livewire.system-info-update-modal-component');
    }

    public function closeModal()
    {
        $this->show_notification = false;
    }
}
