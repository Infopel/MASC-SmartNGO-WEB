<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Myclass\TreeView;
use Symfony\Component\Yaml\Yaml;
use App\Models\RubricasOrcamento as ModelRubricasOrcamento;
use App\Http\Controllers\Helpers\Orcamento\ResumoOrcamentoHelper;
use App\Http\Controllers\Helpers\Orcamento\RubricasOrcamentoHelper;

class RubricasOrcamento extends Component
{
    use ResumoOrcamentoHelper;
    use RubricasOrcamentoHelper;

    public $tab = "resumo";

    public $project;
    public $showModal = false;
    public $importModel = false;

    public $rubrica_slef_id;
    public $rubrica_slef;
    public $rubrica_parent;
    public $rubrica_year;
    public $rubrica_name;
    public $rubrica_value;

    public $search_rubrica;

    public $edit_rubrica;
    public $rubricas = [];
    public $project_provincias = [];
    public $provincia;

    public $rubrica_pai_is_clicked = false;

    public $rubricas_search_result = [];
    public $_totalMensal = [];

    public $filterYear =  'all-years';
    public $ano;

    public function mount($project)
    {
        $this->filters_year();
        foreach ($this->years as $key => $value) {
            $this->filterYear = $value['year'];
        }

        $this->project = $project;

        $this->project_provincias = \App\Models\CustomValues::where('customized_type', 'Project')
            ->where('customized_id', $project->id)
            ->where('custom_field_id', 30)
            ->get();
        $this->load_rubricas();

    }

    public function render()
    {
        return view('livewire.rubricas-orcamento');
    }


    public function toogleTab($tab)
    {
        $this->is_associar_despesas = false;
        $this->tab = $tab;
    }

    public function showModal()
    {
        session()->forget('error');
        session()->forget('success');
        session()->forget('warning');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->edit_rubrica = null;
        $this->showModal = true;
    }

    public function showImportModel()
    {
        $this->importModel = true;
    }

    public function closeModal()
    {
        $this->showModalAssociarOrcamento = false;
        $this->showModal = false;
        $this->importModel = false;
        $this->selected_despesas_ids = [];

        $this->edit_rubrica = null;
        $this->rubrica_slef_id = null;
        $this->rubrica_slef = null;
        $this->rubrica_parent = null;
        $this->rubrica_year = null;
        $this->rubrica_name = null;
        $this->rubrica_value = null;

        $this->rubrica_pai_is_clicked = false;

        $this->selected_rubrica_parent_id = null;
        $this->selected_rubrica_parent_name = null;
        $this->selected_rubrica_parent = null;

        $this->rubrica_parent = null;
    }

    public function rubrica_pai_is_clicked()
    {
        if ($this->rubrica_pai_is_clicked) {
            $this->rubricas_search_result = [];
            $this->rubrica_parent = null;
            return $this->rubrica_pai_is_clicked = false;
        }
        return $this->rubrica_pai_is_clicked = true;
    }


    public function load_rubricas()
    {
        try {
            // $this->rubricas = TreeView::makeView(ModelRubricasOrcamento::select('*', 'parent_rubrica_id as parent_id')
            //     ->with('author', 'parent')
            //     ->where('project_id', $this->project->id)
            //     ->orderBy('rubrica')
            //     ->get());

            $this->rubricas = ModelRubricasOrcamento::select('*', 'parent_rubrica_id as parent_id')
                ->where('project_id', $this->project->id)
                ->where('year',$this->filterYear)
                ->orderBy('rubrica')->get();
            $this->getMonthlyTotals($this->filterYear !== "all-years" ? $this->filterYear : null);
        } catch (\Throwable $th) {
            // throw $th;
            throw new \Exception('Fatal Error while loading rubricas values --- Error_Message' . $th->getMessage());
        }
    }

    /**
     * Store new Resource
     * App\Models\RubricasOrcamento::class
     */
    public function store_rubrica()
    {
        $this->validate([
            'rubrica_slef' => 'required',
            'rubrica_name' => 'required',
            'rubrica_value' => 'required',
            'rubrica_year' => 'required|int|min:4',
        ], [
            'required' => __('lang.errors.messages.required'),
            'int' => __('lang.errors.messages.not_a_number'),
            'min' => __('lang.text_caracters_minimum')
        ], [
            'rubrica_slef' => "Rubrica",
            'rubrica_name' => "Descrição da Rubrica",
            'rubrica_value' => "Orçamento da Rubrica",
            'rubrica_year' => "Ano",
        ]);

        try {
            $new_rubrica = new ModelRubricasOrcamento();

            $new_rubrica->rubrica = $this->rubrica_slef;
            $new_rubrica->name = $this->rubrica_name;
            $new_rubrica->project_id = $this->project->id;
            $new_rubrica->orcamento = $this->rubrica_value;
            $new_rubrica->year = $this->rubrica_year;
            $new_rubrica->parent_rubrica_id = $this->selected_rubrica_parent_id ?? null;
            $new_rubrica->parent_rubrica = $this->selected_rubrica_parent ?? null;
            $new_rubrica->author_id = auth()->user()->id;
            $new_rubrica->created_on = now();
            $new_rubrica->updated_on = now();

            $new_rubrica->save(); // Save data into database

            session()->flash('success', __('lang.notice_successful_create'));
            $this->closeModal();
            $this->load_rubricas();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', __('Encontramos um erro ao tentar criar nova roburica. Verifique se todos os dados estao correctos!'));
            $this->closeModal();
        }
    }

    public $is_editModel = false;
    public function editRubrica($id)
    {
        $this->showModal();

        $this->is_editModel = true;
        $this->edit_rubrica = ModelRubricasOrcamento::where('id', $id)->first();
        if ($this->edit_rubrica) {

            $this->rubrica_slef_id = $this->edit_rubrica->id;
            $this->rubrica_slef = $this->edit_rubrica->rubrica;
            $this->rubrica_year = $this->edit_rubrica->year;
            $this->rubrica_name = $this->edit_rubrica->name;
            $this->rubrica_value = $this->edit_rubrica->orcamento;

            $this->selected_rubrica_parent_id = $this->edit_rubrica->parent->id ?? null;
            $this->selected_rubrica_parent_name = $this->edit_rubrica->parent->name ?? null;
            $this->selected_rubrica_parent = $this->edit_rubrica->parent_rubrica ?? null;
        }
    }

    public $remove_rubrica = null;
    public function removeRubrica($id, $isRemoveTrue = false)
    {
        $this->remove_rubrica = ModelRubricasOrcamento::where('id', $id)->first();
        session()->flash('removeRubrica', true);

        if ($isRemoveTrue) {
            try {
                $this->remove_rubrica->delete();
                $this->remove_rubrica = null;
                session()->flash('success', __('lang.notice_successful_delete'));
                $this->load_rubricas();
            } catch (\Throwable $th) {
                //throw $th;
                session()->flash('error', "Encontramos um error tentando remover a rubrica: " . $this->remove_rubrica->name);
            }
        }
    }

    /**
     * Update Resource
     */
    public function update_rubbrica()
    {
        $this->validate([
            'rubrica_slef' => 'required',
            'rubrica_name' => 'required',
            'rubrica_value' => 'required',
            'rubrica_year' => 'required|int|min:4',
        ], [
            'required' => __('lang.errors.messages.required'),
            'int' => __('lang.errors.messages.not_a_number'),
            'min' => __('lang.text_caracters_minimum')
        ], [
            'rubrica_slef' => "Rubrica",
            'rubrica_name' => "Descrição da Rubrica",
            'rubrica_value' => "Orçamento da Rubrica",
            'rubrica_year' => "Ano",
        ]);

        try {
            $this->edit_rubrica->rubrica = $this->rubrica_slef;
            $this->edit_rubrica->name = $this->rubrica_name;
            $this->edit_rubrica->project_id = $this->project->id;
            $this->edit_rubrica->orcamento = $this->rubrica_value;
            $this->edit_rubrica->year = $this->rubrica_year;
            $this->edit_rubrica->parent_rubrica_id = $this->selected_rubrica_parent_id ?? null;
            $this->edit_rubrica->parent_rubrica = $this->selected_rubrica_parent ?? null;
            $this->edit_rubrica->updated_by = auth()->user()->id;
            $this->edit_rubrica->updated_on = now();

            $this->edit_rubrica->update(); // Save data into database

            session()->flash('success', "<b>Rubrica: " . $this->edit_rubrica['rubrica'] . "." . $this->edit_rubrica['name'] . "</b> - " . __('lang.notice_successful_update'));
            $this->closeModal();
            $this->load_rubricas();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', __('Encontramos um erro ao tentar atualizar roburica. Verifique se todos os dados estao correctos!'));
            $this->closeModal();
        }
    }

    public function updatedRubricaParent()
    {
        if ($this->rubrica_parent == null) {
            return $this->rubricas_search_result = [];
        }
        if ($this->selected_rubrica_parent_id !== null) {
            return $this->rubricas_search_result = ModelRubricasOrcamento::where('project_id', $this->project->id)
                ->where(function ($query) {
                    $query->where('rubrica', $this->rubrica_parent)
                        ->orWhere('name', 'like', '%' . $this->rubrica_parent . "%")
                        ->whereNotIn('id', [$this->selected_rubrica_parent_id]);
                })->get();
        } else {
            return $this->rubricas_search_result = ModelRubricasOrcamento::where('project_id', $this->project->id)
                ->where('id', '!=', $this->rubrica_slef_id)
                ->where(function ($query) {
                    $query->where('rubrica', $this->rubrica_parent)
                        ->orWhere('name', 'like', '%' . $this->rubrica_parent . "%");
                })->get();
        }
    }

    public $selected_rubrica_parent = null;
    public $selected_rubrica_parent_id;
    public $selected_rubrica_parent_name;
    public function selected_rubrica_parent($id = null, $rubrica = null, $name = null)
    {
        if ($id !== null && $name !== null) {
            $get_rubrica = ModelRubricasOrcamento::where('id', $id)->first();
            $this->selected_rubrica_parent = $get_rubrica->parent_rubrica ?? $rubrica;
            $this->selected_rubrica_parent_id = $id;
            $this->selected_rubrica_parent_name = $name;
        } else {
            $this->selected_rubrica_parent_name = "Sem Rubrica Pai";
            $this->selected_rubrica_parent_id = null;
            $this->selected_rubrica_parent = null;
        }
        $this->rubrica_pai_is_clicked = false;
    }


    public $years = [2020];
    public function filters_year()
    {
        $this->years = ModelRubricasOrcamento::select('year')->where('year','!=',null)->groupBy('year')->get()->toArray();
    }

    public function updatedSearchRubrica()
    {
        $this->rubricas = ModelRubricasOrcamento::select('*', 'parent_rubrica_id as parent_id')
            ->where('project_id', $this->project->id)
            ->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search_rubrica . '%')
                    ->orWhere('rubrica', 'like', '%' . $this->search_rubrica . '%');
            })
            ->where(function ($query) {
                if ($this->filterYear !== "all-years") {
                    $query->where('year', $this->filterYear);
                }
            })
            ->orderBy('rubrica')->get();
    }

    public function updatedFilterYear()
    {
        $this->rubricas = ModelRubricasOrcamento::select('*', 'parent_rubrica_id as parent_id')
            ->where('project_id', $this->project->id)
            ->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search_rubrica . '%')
                    ->orWhere('rubrica', 'like', '%' . $this->search_rubrica . '%');
            })
            ->where(function ($query) {
                if ($this->filterYear !== "all-years") {
                    $query->where('year', $this->filterYear);
                }
            })
            ->orderBy('rubrica')->get();

        $this->getMonthlyTotals($this->filterYear !== "all-years" ? $this->filterYear : null);
    }

    public function getMonthlyTotals($year = null)
    {
        $this->_totalMensal = [
            '_jan' => $this->orcamento_total_gasto(1, $year),
            '_feb' => $this->orcamento_total_gasto(2, $year),
            '_mar' => $this->orcamento_total_gasto(3, $year),
            '_apr' => $this->orcamento_total_gasto(4, $year),
            '_may' => $this->orcamento_total_gasto(5, $year),
            '_jun' => $this->orcamento_total_gasto(6, $year),
            '_jul' => $this->orcamento_total_gasto(7, $year),
            '_aug' => $this->orcamento_total_gasto(8, $year),
            '_sep' => $this->orcamento_total_gasto(9, $year),
            '_oct' => $this->orcamento_total_gasto(10, $year),
            '_nov' => $this->orcamento_total_gasto(11, $year),
            '_dec' => $this->orcamento_total_gasto(12, $year),
            "_anual_total" => $this->orcamento_total_gasto(null, $year),
        ];
    }

    /**
     * retorna o tatal gasto
     *
     * @param int $mes
     * @param int $ano
     */
    public function orcamento_total_gasto(int $mes = null, int $ano = null)
    {
        return $this->total_orcamento_gasto($this->project->id, [
            'mes' => $mes,
            'ano' => $ano
        ]);
    }
}
