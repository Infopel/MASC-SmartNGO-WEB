<?php

namespace App\Http\Livewire;

use App\Models\Partners;
use Livewire\Component;
use App\Models\ProjectsPartners;

class ProjectPartners extends Component
{

    public $showModal = false;
    public $project;

    public $selected_partners_ids = [];

    public $project_partners = [];
    public $partners = [];
    public $input_partner;
    public $type = null;

    public function mount($project)
    {
        $this->project = $project;
        $this->load_project_partners();

    }

    public function render()
    {
        return view('livewire.project-partners');
    }


    public $_partners = [];
    public function load_project_partners()
    {
        $this->project_partners = ProjectsPartners::with('partner')
            ->where('project_id', $this->project->id)
            ->get();
    }

    private function load_partners()
    {
        if(sizeof($this->project_partners) > 0){
            return $this->partners = Partners::with('tipo')
                ->whereNotIn('id', array_column($this->project_partners->toArray(), 'partner_id'))
                ->get();
        }
        return $this->partners = Partners::with('tipo')->get();
    }


    public function showModal()
    {
        $this->showModal = true;
        $this->input_partner = null;
        $this->load_partners();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->partner = [];
    }

    public function updatedInputPartner()
    {
        if ($this->input_partner !== null) {
            if (sizeof($this->project_partners) > 0){
                return $this->partners = Partners::with('tipo')->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->input_partner . '%');
                })->whereNotIn('id', array_column($this->project_partners->toArray(), 'partner_id'))->get();
            }
            return $this->partners = Partners::with('tipo')->where(function ($query) {
                $query->where('name', 'like', '%' . $this->input_partner . '%');
            })->get();
        }
        return $this->load_partners();
    }

    /**
     * Store Project partners
     */
    public function store_project_partner()
    {
        if(sizeof($this->selected_partners_ids) < 1){
            $this->closeModal(); // Close the modal
            return session()->flash('warning', 'Nehum Parceiro selecionado! Selecione pelo menos um.');
        }
        try {
            foreach ($this->selected_partners_ids as $partner) {
                //dd($this->type);
                $project_partner = new ProjectsPartners();
                $project_partner->project_id = $this->project->id;
                $project_partner->partner_id = $partner;
                $project_partner->type = $this->type;
                $project_partner->save(); // Save data into database
            }
            session()->flash('success', $project_partner->name . " " . __('lang.notice_successful_create'));
            $this->load_project_partners(); // LoadProjectPartners
            $this->closeModal(); // Close the modal
            $this->selected_partners_ids = [];
            $this->type = null;
        } catch (\Throwable $th) {
            //throw $th;
            // session()->flash('error', $th->getMessage());
            $this->closeModal(); // Close the modal
            session()->flash('error', "Encontramos um erro no cadastro de parceiro para o projecto.");
        }
    }

    public $to_remove_project_partner;
    public function remove_partner_from_project($partner_id, $isRemoveTrue = false)
    {
        $this->to_remove_project_partner = ProjectsPartners::where('project_id', $this->project->id)
            ->where('partner_id', $partner_id)->first();
        session()->flash('removePartner', true);
        if ($isRemoveTrue){
            try {
                $this->to_remove_project_partner->delete();
                session()->flash('success', $this->to_remove_project_partner->name." ".__('lang.notice_successful_delete'));
                $this->to_remove_project_partner = null;
                $this->load_project_partners();
                return session()->flash('success', __('lang.notice_successful_delete'));
            } catch (\Throwable $th) {
                //throw $th;
                session()->flash('error', __('Encontramos um erro ao tentar remover o parceiro: '. $this->to_remove_project_partner->name.' do projecto'));
                $this->to_remove_project_partner = null;
                $this->closeModal(); // Close the modal
            }
        }
    }
}
