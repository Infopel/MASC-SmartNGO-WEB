<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AttachmentsFormFields extends Component
{

    public $title; // Titulo da seccao

    public function mount($title)
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('livewire.attachments-form-fields');
    }

    public $file_forms = [];

    /**
     * Adionar arquivos / documentos de suporte
     *
     * @return array $attachments
     */
    /**
     * add file forms
     */
    public function add_file_forms($index)
    {
        array_push($this->file_forms, ['index' => sizeof($this->file_forms) + 1]);
    }

    public function remove_file_forms($key, $index)
    {
        $this->file_forms = array_diff_key($this->file_forms, array($key => $index));
    }
}
