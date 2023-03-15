<?php

namespace App\Http\Livewire;

use App\Models\Iniciativa;
use Livewire\Component;
use App\Models\Localizacao;
use phpDocumentor\Reflection\Types\This;

class Iniciativas extends Component
{

    // public $search;
    public $iniciativa_id, $nome, $tipoIniciativa , $idLocalizacao, $bairro, $dataConstituicao, $idResponsavel, $idMobilizador, $updatedBy, $project_id,$iniciativa_edit_id, $iniciativa_delete_id;
    public $view_iniciativa_id, $view_iniciativa_nome, $view_iniciativa_tipoIniciativa , $view_iniciativa_idLocalizacao, $view_iniciativa_bairro, $view_iniciativa_dataConstituicao, $view_iniciativa_idResponsavel, $view_iniciativa_idMobilizador, $view_iniciativa_updatedBy, $view_iniciativa_project_id;
    ///---------------------------------------------------------------------------------------------------------------------------
    //Input fields on update validation
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'iniciativa_id' => 'required|unique:iniciativas,iniciativa_id,'.$this->iniciativa_edit_id.'', //Validation with ignoring own data
            'nome' => 'required|string',
            'idLocalizacao' => 'null',
            'bairro' => 'required|string',
            'dataConstituicao' => 'null',
            'idResponsavel' => 'required|numeric',
            'idMobilizador' => 'required|numeric',
            'updatedBy' => 'required|string',
            'project_id' => 'required|string',
        ]);
    }

    public function resetInputs()
    {
        $this->nome = '';
        $this->tipoIniciativa = '';
        $this->idLocalizacao = '';
        $this->bairro = '';
        $this->dataConstituicao = '';
        $this->idResponsavel = '';
        $this->idMobilizador = '';
        $this->updatedBy = '';
        $this->project_id = '';
        $this->iniciativa_edit_id = '';
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function editIniciativas($id)
    {
        $iniciativa = Iniciativa::where('id', $id)->first();

        // $this->iniciativa_edit_id = $iniciativa->id;
        $this->iniciativa_id = $iniciativa->iniciativa_id;
        
        // $this->iniciativa_edit_id=$iniciativa->id;
        $this->nome = $iniciativa->nome;
        $this->tipoIniciativa = $iniciativa->tipoIniciativa;
        $this->idLocalizacao = $iniciativa->idLocalizacao;
        $this->bairro = $iniciativa->bairro;
        $this->dataConstituicao = $iniciativa->dataConstituicao;
        $this->idResponsavel = $iniciativa->idResponsavel;
        $this->idMobilizador = $iniciativa->idMobilizador;
        $this->updatedBy = $iniciativa->updatedBy;
        $this->project_id = $iniciativa->project_id;

        $this->dispatchBrowserEvent('show-edit-iniciativa-modal');
    }
    
    public function editIniciativaData()
    {
        //on form submit validation
        // $this->validate([
        //     'iniciativa_id' => 'required|unique:iniciativas,iniciativa_id,'.$this->iniciativa_edit_id.'', //Validation with ignoring own data
        //     'nome' => 'required|string',
        //     'idLocalizacao' => 'required',
        //     'bairro' => 'required|string',
        //     'dataConstituicao' => 'v',
        //     'idResponsavel' => 'required|numeric',
        //     'idMobilizador' => 'required|numeric',
        //     'updatedBy' => 'required|string',
        //     'project_id' => 'required|string',

        // ]);

        $iniciativa = Iniciativa::where('id', $this->iniciativa_edit_id)->first();
        $iniciativa->iniciativa_id = $this->iniciativa_id;
        $iniciativa->nome = $this->nome;
        $iniciativa->tipoIniciativa = $this->tipoIniciativa;
        $iniciativa->idLocalizacao = $this->idLocalizacao;
        $iniciativa->bairro = $this->bairro;
        $iniciativa->dataConstituicao = $this->dataConstituicao;
        $iniciativa->idResponsavel = $this->idResponsavel;
        $iniciativa->idMobilizador = $this->idMobilizador;
        $iniciativa->updatedBy = $this->updatedBy;
        $iniciativa->project_id = $this->project_id;

        $iniciativa->save();

        session()->flash('message', 'Iniciativa has been updated successfully');

        //For hide modal after add Iniciativa success
        $this->dispatchBrowserEvent('close-modal');
    }

    //Delete Confirmation
    public function deleteConfirmation($id)
    {
        $this->iniciativa_delete_id = $id; //iniciativa id

        $this->dispatchBrowserEvent('show-delete-confirmation-modal');
    }

    public function deleteinIciativaData($id)
    {
        $iniciativa = Iniciativa::where('id', $this->iniciativa_delete_id)->first();
        $iniciativa->delete();

        session()->flash('message', 'iniciativa has been deleted successfully');

        $this->dispatchBrowserEvent('close-modal');

        $this->iniciativa_delete_id = '';
    }

    public function cancel()
    {
        $this->iniciativa_delete_id = '';
    }
    //////-------------------------------------------------------------------------------------------------------------


    // public function updatedSearch()
    // {
    //     if ($this->sview_iniciativa_idearch !== '') {
    //         return $this->approvement_flows = Iniciativa::where('nome', 'like', '%' . $this->search . '%')->get();
    //     }
    // }

    public function viewIniciativaDetails($id)
    {
        $iniciativa = Iniciativa::where('id', $id)->first();
        // dd($view_iniciativa_id = $iniciativa->id);
        $this->$view_iniciativa_id = $iniciativa->iniciativa_id;
        $this->$view_iniciativa_nome= $iniciativa->nome;
        $this->$view_iniciativa_tipoIniciativa= $iniciativa->tipoIniciativa;
        $this->$view_iniciativa_idLocalizacao= $iniciativa->idLocalizacao;
        $this->$view_iniciativa_bairro= $iniciativa->bairro;
        $this->$view_iniciativa_dataConstituicao= $iniciativa->dataConstituicao;
        $this->$view_iniciativa_idResponsavel= $iniciativa->idResponsavel;
        $this->$view_iniciativa_idMobilizador= $iniciativa->idMobilizador;
        $this->$view_iniciativa_updatedBy= $iniciativa->updatedBy;
        $this->$view_iniciativa_project_id= $iniciativa->project_id;


        $this->dispatchBrowserEvent('show-view-iniciativa-modal');
    }
    public function closeViewIniciativaModal()
    {
        $this->$view_student_id = '';
        $this->$view_iniciativa_nome= '';
        $this->$view_iniciativa_tipoIniciativa= '';
        $this->$view_iniciativa_idLocalizacao= '';
        $this->$view_iniciativa_bairro= '';
        $this->$view_iniciativa_dataConstituicao= '';
        $this->$view_iniciativa_idResponsavel= '';
        $this->$view_iniciativa_idMobilizador= '';
        $this->$view_iniciativa_updatedBy= '';
        $this->$view_iniciativa_project_id= '';
    }

    public function render()
    {
        
        $iniciativas=Iniciativa::with('Localizacao')->get();
        return view('livewire.iniciativas',['iniciativas'=>$iniciativas]);
        
    }
}
