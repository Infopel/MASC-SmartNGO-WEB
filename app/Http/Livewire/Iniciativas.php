<?php

namespace App\Http\Livewire;

use App\Models\Iniciativa;
use Livewire\Component;
use App\Models\Localizacao;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\This;

class Iniciativas extends Component
{

    public $search;
    public $iniciativa_id, $nome, $tipoIniciativa , $idLocalizacao, $bairro, $dataConstituicao, $idResponsavel, $idMobilizador, $updatedBy, $project_id,$iniciativa_edit_id;



    public $show_form_modal = false;


    /**
     * load_iniciativas
     */
    public function load_iniciativas(bool $is_active = true, $isDeleted = false)
    {
        if ($isDeleted) {
            return $this->iniciativas = Iniciativa::all();
        }
    }

 
    //Input fields on update validation
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'id' => 'required|unique:iniciativa,id,'.$this->iniciativa_edit_id.'', //Validation with ignoring own data
            'nome' => 'required|string',
            'idLocalizacao' => 'string',
            'bairro' => 'required|string',
            'dataConstituicao' => 'null',
            'idResponsavel' => 'required|numeric',
            'idMobilizador' => 'required|numeric',
            'updatedBy' => 'required|string',
            'project_id' => 'required|string',
        ]);
    }

    public function closeModal()
    {

        $this->show_form_modal = false;

        // Clear Var data
        $this->nome = '';
        $this->tipoIniciativa = '';
        $this->idLocalizacao = '';
        $this->bairro = '';
        // $this->dataConstituicao = '';
        // $this->idResponsavel = '';
        // $this->idMobilizador = '';
        // $this->updatedBy = '';
        // $this->project_id = '';
        // $this->iniciativa_edit_id = '';

        $this->load_iniciativas();
    }

    public $enable_on = [];

    public function edit($id)
    {
        try{
            $enable_on = Iniciativa::where('id', $id)->first();

            $this->iniciativa_id = $enable_on->id;
            
            $this->nome = $enable_on->nome;
            $this->tipoIniciativa = $enable_on->tipoIniciativa;
            // dd($this->idLocalizacao = $enable_on->idLocalizacao);
            $this->bairro = $enable_on->bairro;
            // $this->dataConstituicao = $enable_on->dataConstituicao;
            // $this->idResponsavel = $enable_on->idResponsavel;
            // $this->idMobilizador = $enable_on->idMobilizador;
            $this->updatedBy = $enable_on->updatedBy;
            // $this->project_id = $enable_on->project_id;
            

            $this->show_form_modal = true;

        } catch (\Throwable $th) {
            // throw $th;
            return session()->flash('error', 'Ocorreu um erro! Esse na funcao de edicao');
        }
    }
    

    public function updateIniciativas($id)
    {

        $this->validate([
            'id' => 'required|unique:iniciativa,id,'.$this->iniciativa_edit_id.'',
            // 'nome' => 'required|string',
            'idLocalizacao' => 'required',
            'bairro' => 'required|string',
            // 'dataConstituicao' => 'date',
            // 'idResponsavel' => 'required|numeric',
            // 'idMobilizador' => 'required|numeric',
            // 'updatedBy' => 'required|string',
            // 'project_id' => 'required|string',

        ]);

    try {

        $enable_on = Iniciativa::where('id',$id)->firstOrFail();

        $this->$enable_on->id = $this->iniciativa_id;
        $this->$enable_on->nome = $this->nome;
        $this->$enable_on->tipoIniciativa = $this->tipoIniciativa;
        $this->$enable_on->idLocalizacao = $this->idLocalizacao;
        $this->$enable_on->bairro = $this->bairro;
        $this->$enable_on->dataConstituicao = $this->dataConstituicao;
        $this->$enable_on->idResponsavel = $this->idResponsavel;
        $this->$enable_on->idMobilizador = $this->idMobilizador;
        $this->$enable_on->updatedBy = $this->updatedBy;
        $this->$enable_on->project_id = $this->project_id;
        $this->$enable_on->updated_on = now();

        // $this->enable_on->save(); // Save data into database
        $this->enable_on->update(); // Save data into database
        $this->load_iniciativas();
        $this->closeModal(); 

        return session()->flash('success', __('lang.notice_successful_update'));
    } catch (\Throwable $th) {
        throw $th;
        return session()->flash('error', 'Ocorreu um erro ao actualizar');
    }


    }


    public function delete($id, $is_submit = false)
    {

        /**
         * Delete if is submit delete enabled
         */
        try {
            $iniciativa = Iniciativa::where('id', $id)->firstOrFail();
            $iniciativa->delete();

            return session()->flash('success', __('lang.notice_successful_delete'));
        } catch (\Throwable $th) {
            //throw $th;
            return session()->flash('error', 'Ocorreu um erro ao remover o fluxo selecionado');
        }
        
    }



    public function render()
    {
        
        $iniciativas=Iniciativa::with('Localizacao')->get();
        return view('livewire.iniciativas',['iniciativas'=>$iniciativas]);
        
    }
}
