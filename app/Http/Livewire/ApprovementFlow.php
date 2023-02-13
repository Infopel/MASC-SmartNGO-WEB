<?php

namespace App\Http\Livewire;

use App\Models\Roles;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\AppApprovementFlows;
use App\Models\WorkFlowDecisionTree;
use App\Models\ApprovementFlow as ApprovementFlows;

class ApprovementFlow extends Component
{

    public $approvement_flows = [];
    public $roles = [];
    public $status = true;
    public $show_form_modal = false;
    public $show_form_modal_flow = false;
    public $search;

    public $action = 'store';

    // form filds vars binds
    public $type = "Issue";
    public $description;
    public $trigger = "processs_flow";
    public $role_id;
    public $is_active;
    public $email_notification_content;
    public $unapproval_email_content;
    public $is_flow_end = false;
    public $is_email_conent_view = false;

    public $workflow_decision_trees = [];
    public $use_decision_tree = 0;
    public $decision_tree_title = "";
    public $decision_tree_positive_goto;
    public $decision_tree_negative_goto;

    public $flow_approve_goto;
    public $not_approved_goto;


    public $flowType = 'issueActivities';
    public $app_flow;

    public $approvementFlows;

    /**
     * Component mount
     */
    public function mount()
    {
        $this->roles = Roles::where('builtin', false)->get();
        $this->load_approvement_flows();

        $this->approvementFlows = AppApprovementFlows::where('isActive', true)->get();

        try {
            $this->app_flow = AppApprovementFlows::where('isActive', true)->firstOrFail();
            $this->flowType = $this->app_flow->tagCode;
        } catch (\Throwable $th) {
            throw new \Exception("No result found on table App Approvement Flows");
        }

        $this->type = $this->flowType;

        $this->workflow_decision_trees = WorkFlowDecisionTree::where('app_workflow_id', $this->app_flow->id)->get();
    }

    public function render()
    {
        return view('livewire.approvement-flow');
    }

    /**
     * load_approvement_flows
     */
    public function load_approvement_flows(bool $is_active = true, $isDeleted = false)
    {
        if ($isDeleted) {
            return $this->approvement_flows = ApprovementFlows::where('type', $this->flowType)->onlyTrashed()->get();
        }
        $this->approvement_flows = ApprovementFlows::where('type', $this->flowType)->where('is_active', $is_active)->get();
        $this->app_flow = AppApprovementFlows::where('isActive', true)->firstOrFail();
        $this->workflow_decision_trees = WorkFlowDecisionTree::where('app_workflow_id', $this->app_flow->id)->get();
    }

    /**
     * show modal for approve flow step creation
     */
    public function show_modal_create_flow()
    {
        $this->show_form_modal = true;
        $this->is_email_conent_view = false;
    }

    /**
     * show modal for approve flow creation
     */
    public function show_new_modal_create_flow()
    {
        $this->show_form_modal_flow = true;
        $this->is_email_conent_view = false;
    }



    /**
     * Open Edit Modal
     */
    public $is_edit = false;
    public $enable_edit_on = [];
    public function edit($flow_id, $is_email_conent_view = false)
    {
        if ($is_email_conent_view) {
            $this->is_email_conent_view = true;
        }

        try {
            $this->enable_edit_on = ApprovementFlows::where('id', $flow_id)->with('decision_tree')->firstOrFail();
            $this->action = "update";
            $this->is_edit = true;

            $this->type = $this->enable_edit_on->type;
            $this->description = $this->enable_edit_on->description;
            $this->trigger = $this->enable_edit_on->trigger;
            $this->role_id = $this->enable_edit_on->role_id;
            $this->is_active = $this->enable_edit_on->is_active;
            $this->email_notification_content = $this->enable_edit_on->email_content;
            $this->is_flow_end = $this->enable_edit_on->is_flow_end;
            $this->not_approved_goto = $this->enable_edit_on->not_approved_goto;
            $this->approve_goto = $this->enable_edit_on->approve_goto;
            $this->use_decision_tree = $this->enable_edit_on->has_decision_tree;
            $this->unapproval_email_content = $this->enable_edit_on->unapproval_email_content;

            if ($this->enable_edit_on->has_decision_tree) {
                // this will ensure that the current aprovement flow will not be listed on the dropdown to choose where the decision_tree should goto.
                $this->approvement_flows = ApprovementFlows::where('type', $this->flowType)->where('is_active', true)->whereNotIn('id', [$this->enable_edit_on->id])->get();

                $this->decision_tree_title = $this->enable_edit_on->decision_tree->title;
                $this->decision_tree_positive_goto =  $this->enable_edit_on->decision_tree->on_positive_goto;
                $this->decision_tree_negative_goto =  $this->enable_edit_on->decision_tree->on_negative_goto;
            }

            $this->show_form_modal = true;
        } catch (\Throwable $th) {
            // throw $th;
            return session()->flash('error', 'Ocorreu um erro! Esse Passo do fluxo pode ter sido removido por outro usuario');
        }
    }

    public function closeNewModal()
    {
        $this->show_form_modal_flow = false;
        $this->is_email_conent_view = false;
        $this->is_edit = false;

        // Clear Var data
        $this->type = null;
        $this->description = null;
        $this->load_approvement_flows();
    }

    public function closeModal()
    {
        $this->show_form_modal = false;
        $this->is_email_conent_view = false;
        $this->is_edit = false;

        // Clear Var data
        $this->type = null;
        $this->description = null;
        $this->trigger = null;
        $this->role_id = null;
        $this->is_active = null;
        $this->email_notification_content = null;
        $this->unapproval_email_content = null;
        $this->decision_tree_title = null;
        $this->decision_tree_positive_goto =  null;
        $this->decision_tree_negative_goto = null;
        $this->load_approvement_flows();
    }


    /**
     * Real time validation
     */
    public function updated($field)
    {
        $this->validateOnly($field, [
            'description' => 'required|string',
        ], [
            'required' => __('lang.errors.messages.required'),
        ], [
            'description' => __('lang.field_description'),
        ]);
    }

    /**
     * Update Approvement Flow
     */
    public function update_approvement_flow()
    {

        /**
         * Check if description is changed and validate to avoid
         * approvement flows with same name
         */
        $this->validate([
            'description' => 'required|string|unique:approvement_flow,description,' . $this->enable_edit_on->id,
            'type' => 'required',
            'role_id' => 'required|int',
        ], [
            'required' => __('lang.errors.messages.required'),
            'unique' => __('lang.errors.messages.taken')
        ], [
            'type' => __('lang.field_type'),
            'description' => __('lang.field_description'),
            'role_id' => __('lang.label_role'),
        ]);

        try {
            //dd($this->not_approved_goto);
            $this->enable_edit_on->type = $this->type;
            $this->enable_edit_on->description = $this->description;
            $this->enable_edit_on->trigger = $this->trigger;
            $this->enable_edit_on->role_id = $this->role_id;
            $this->enable_edit_on->is_active = $this->is_active;
            $this->enable_edit_on->email_content = $this->email_notification_content;
            $this->enable_edit_on->unapproval_email_content = $this->unapproval_email_content;
            $this->enable_edit_on->author_id = auth()->user()->id;
            $this->enable_edit_on->created_on = now();
            $this->enable_edit_on->updated_on = now();
            $this->enable_edit_on->has_decision_tree = $this->use_decision_tree;
            $this->enable_edit_on->approved_goto = $this->flow_approve_goto;
            $this->enable_edit_on->is_flow_end = $this->trigger == "output_flow" ? true : false;
            $this->enable_edit_on->not_approved_goto = $this->not_approved_goto;

            if ($this->enable_edit_on->has_decision_tree) {

                try {
                    $decision_tree = WorkFlowDecisionTree::where("id", $this->enable_edit_on->decision_tree->id)->firstOrFail();

                    $decision_tree->title = $this->decision_tree_title;
                    $decision_tree->on_positive_goto = $this->decision_tree_positive_goto;
                    $decision_tree->on_negative_goto = $this->decision_tree_negative_goto;
                    $decision_tree->author_id = auth()->user()->id;
                    $decision_tree->app_workflow_id = $this->app_flow->id;

                    $decision_tree->update(); // Update data into database
                } catch (\Throwable $th) {
                    //dd($this->flowType);
                    $decision_tree = new WorkFlowDecisionTree();
                    $decision_tree->title = $this->decision_tree_title;
                    $decision_tree->on_positive_goto = $this->decision_tree_positive_goto;
                    $decision_tree->on_negative_goto = $this->decision_tree_negative_goto;
                    $decision_tree->author_id = auth()->user()->id;
                    $decision_tree->app_workflow_id = $this->app_flow->id;

                    $decision_tree->save(); // Save data into database

                    $this->enable_edit_on->has_decision_tree = true;
                    $this->enable_edit_on->decision_tree_id = $decision_tree->id;
                }
            }

            if (!$this->enable_edit_on->has_decision_tree) {
                try {
                    WorkFlowDecisionTree::where("id", $this->enable_edit_on->decision_tree->id)->delete();
                    $this->enable_edit_on->decision_tree_id = null;
                } catch (\Throwable $th) {
                    // do not throw an exception here, this shouldd be this way
                }
            }

            $this->enable_edit_on->update(); // Save data into database
            $this->load_approvement_flows();
            $this->closeModal();
            $this->enable_edit_on = [];

            return session()->flash('success', __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            throw $th;
            return session()->flash('error', 'Ocorreu um erro ao uptualizar os dados! Contacte o Administrador');
        }
    }

    /**
     * Store ApprovementFlows
     */
    public function store_approvement_flow()
    {
        if ($this->action == 'store') {

            $this->validate([
                'type' => 'required',
                'description' => 'required|string|unique:approvement_flow,description',
                'role_id' => 'required|int',
                'is_active' => 'required|boolean',
            ], [
                'required' => __('lang.errors.messages.required')
            ], [
                'type' => __('lang.field_type'),
                'description' => __('lang.field_description'),
                'role_id' => __('lang.label_role'),
                'is_active' => __('lang.field_active'),
            ]);

            if ($this->trigger == "output_flow") {
                $this->is_flow_end = true;
            }

            if ($this->use_decision_tree) {
                $this->validate([
                    'decision_tree_title' => 'required|string|unique:workflow_decision_tree,title',
                    'decision_tree_positive_goto' => 'required',
                    'decision_tree_negative_goto' => 'required',
                ], [
                    'required' => __('lang.errors.messages.required')
                ], [
                    'title' => __('Titulo'),
                    'decision_tree_positive_goto' => __('Validação Positiva (Sim)'),
                    'decision_tree_negative_goto' => __('Validação Negativa (Não)'),
                ]);
            }

            try {

                $approvement_flow = new ApprovementFlows();
                $approvement_flow->position = ApprovementFlows::count() + 1;
                $approvement_flow->type = $this->type;
                $approvement_flow->description = $this->description;
                $approvement_flow->trigger = $this->trigger ?? null;
                $approvement_flow->role_id = $this->role_id;
                $approvement_flow->is_active = $this->is_active;
                $approvement_flow->email_content = $this->email_notification_content;
                $approvement_flow->author_id = auth()->user()->id;
                $approvement_flow->created_on = now();
                $approvement_flow->updated_on = now();

                $approvement_flow->approved_goto = $this->approved_goto;;
                $approvement_flow->not_approved_goto = $this->not_approved_goto;
                $approvement_flow->is_flow_end = $this->trigger == "output_flow" ? true : false;


                if ($this->use_decision_tree) {
                    $decision_tree = new WorkFlowDecisionTree();
                    $decision_tree->title = $this->decision_tree_title;
                    $decision_tree->app_workflow_id = $this->app_flow->id;
                    $decision_tree->author_id = auth()->user()->id;
                    $decision_tree->on_positive_goto = $this->decision_tree_positive_goto;
                    $decision_tree->on_negative_goto = $this->decision_tree_negative_goto;

                    $decision_tree->save(); // Save data into database

                    $approvement_flow->has_decision_tree = true;
                    $approvement_flow->decision_tree_id = $decision_tree->id;
                }
                $approvement_flow->save(); // Save data into database

                $this->load_approvement_flows();
                $this->closeModal();
                return session()->flash('success', __('lang.notice_successful_create'));
                // $approvement_flow->position = $this->approvement_flows->last();
            } catch (\Throwable $th) {
                // throw $th;
                return session()->flash('error', 'Ocorreu um erro ao gravar os dados! Contacte o Administrador');
            }
        }
    }

    /**
     * Store ApprovementFlows Types
     */
    public function store_type_approvement_flow()
    {
        if ($this->action == 'store') {

            $this->validate([
                'description' => 'required|string',
            ], [
                'required' => __('lang.errors.messages.required')
            ], [
                'description' => __('lang.field_description'),
            ]);


            try {

                $approvement_flow = new AppApprovementFlows();
                $approvement_flow->title = $this->description;
                $approvement_flow->tagCode = str_replace(' ', '', $this->description);
                $approvement_flow->isAssociated_with = "issues";
                $approvement_flow->isActive = 1;
                //$approvement_flow->author_id = auth()->user()->id;
                $approvement_flow->created_on = now();
                $approvement_flow->updated_on = now();

                $approvement_flow->save(); // Save data into database
                //dd('Folege');
                $this->approvementFlows = AppApprovementFlows::where('isActive', true)->get();
                $this->closeNewModal();
                return session()->flash('success', __('lang.notice_successful_create'));
                // $approvement_flow->position = $this->approvement_flows->last();
            } catch (\Throwable $th) {
                throw $th;
                return session()->flash('error', 'Ocorreu um erro ao gravar os dados! Contacte o Administrador');
            }
        }
    }

    /**
     * Update Approvement Flow Types
     */
    public function update_type_approvement_flow()
    {

        /**
         * Check if description is changed and validate to avoid
         * approvement flows with same name
         */
        $this->validate([
            'description' => 'required|string|unique:approvement_flow,description,' . $this->enable_edit_on->id,
            'type' => 'required',
            'role_id' => 'required|int',
        ], [
            'required' => __('lang.errors.messages.required'),
            'unique' => __('lang.errors.messages.taken')
        ], [
            'type' => __('lang.field_type'),
            'description' => __('lang.field_description'),
            'role_id' => __('lang.label_role'),
        ]);

        try {

            $this->enable_edit_on->type = $this->type;
            $this->enable_edit_on->description = $this->description;
            $this->enable_edit_on->trigger = $this->trigger;
            $this->enable_edit_on->role_id = $this->role_id;
            $this->enable_edit_on->is_active = $this->is_active;
            $this->enable_edit_on->email_content = $this->email_notification_content;
            $this->enable_edit_on->unapproval_email_content = $this->unapproval_email_content;
            $this->enable_edit_on->author_id = auth()->user()->id;
            $this->enable_edit_on->created_on = now();
            $this->enable_edit_on->updated_on = now();
            $this->enable_edit_on->has_decision_tree = $this->use_decision_tree;
            $this->enable_edit_on->approved_goto = $this->use_decision_tree ? $this->flow_approve_goto : null;
            $this->enable_edit_on->is_flow_end = $this->trigger == "output_flow" ? true : false;
            $this->enable_edit_on->not_approved_goto = $this->not_approved_goto;

            if ($this->enable_edit_on->has_decision_tree) {

                try {
                    $decision_tree = WorkFlowDecisionTree::where("id", $this->enable_edit_on->decision_tree->id)->firstOrFail();

                    $decision_tree->title = $this->decision_tree_title;
                    $decision_tree->on_positive_goto = $this->decision_tree_positive_goto;
                    $decision_tree->on_negative_goto = $this->decision_tree_negative_goto;

                    $decision_tree->update(); // Update data into database
                } catch (\Throwable $th) {
                    $decision_tree = new WorkFlowDecisionTree();
                    $decision_tree->title = $this->decision_tree_title;
                    $decision_tree->on_positive_goto = $this->decision_tree_positive_goto;
                    $decision_tree->on_negative_goto = $this->decision_tree_negative_goto;

                    $decision_tree->save(); // Save data into database

                    $this->enable_edit_on->has_decision_tree = true;
                    $this->enable_edit_on->decision_tree_id = $decision_tree->id;
                }
            }

            $this->enable_edit_on->update(); // Save data into database
            $this->load_approvement_flows();
            $this->closeModal();
            $this->enable_edit_on = [];

            return session()->flash('success', __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            throw $th;
            return session()->flash('error', 'Ocorreu um erro ao uptualizar os dados! Contacte o Administrador');
        }
    }

    public function updatedSearch()
    {
        if ($this->search !== '') {
            return $this->approvement_flows = ApprovementFlows::where('description', 'like', '%' . $this->search . '%')->get();
        }
    }

    private $selected_status = true;
    public function updatedStatus()
    {
        switch ($this->status) {
            case 'active':
                $this->selected_status = true;
                $this->load_approvement_flows($this->selected_status);
                break;
            case 'inactive':
                $this->selected_status = false;
                $this->load_approvement_flows($this->selected_status);
                break;
            case 'deleted':
                $this->load_approvement_flows($this->selected_status, true);
                break;
        }
    }

    /**
     * On user change Flow type
     */
    public function updatedFlowType()
    {
        $this->status = 'active';
        $this->updatedStatus();
        $this->type = $this->flowType;

        //Get app approval flow
        $this->app_flow = AppApprovementFlows::where('isActive', true)->where('tagCode', $this->flowType)->firstOrFail();
        //Load workflow based on the selected workflow type
        $this->workflow_decision_trees = WorkFlowDecisionTree::where('app_workflow_id', $this->app_flow->id)->get();
    }

    /**
     * Delete Workflows
     */
    public $enable_delete_on = [];

    /**
     * Init Delete Request
     */
    public function delete($flow_id, $is_submit = false)
    {
        if (!$is_submit) {
            $this->enable_delete_on = array($flow_id);
            return;
        }

        /**
         * Delete if is submit delete enabled
         */
        try {
            $approvement_flow = ApprovementFlows::where('id', $flow_id)->firstOrFail();
            $approvement_flow->delete();

            $this->enable_delete_on = [];
            $this->load_approvement_flows();
            return session()->flash('success', __('lang.notice_successful_delete'));
        } catch (\Throwable $th) {
            //throw $th;
            return session()->flash('error', 'Ocorreu um erro ao remover o fluxo selecionado');
        }
    }

    public $enable_delete_decision_tree_on = [];

    public function delete_decision_tree($decision_tree_id, $is_submit = false)
    {
        if (!$is_submit) {
            $this->enable_delete_decision_tree_on = array($decision_tree_id);
            return;
        }

        /**
         * Delete if is submit delete enabled
         */
        try {
            DB::beginTransaction();
            $approvement_flow = WorkFlowDecisionTree::where('id', $decision_tree_id)->firstOrFail();
            $approvement_flow->delete();

            // remove Relation with workflow when delete decision node
            $this->approvement_flow = ApprovementFlows::where('decision_tree_id', $decision_tree_id)->first();
            $this->approvement_flow->has_decision_tree = null;
            $this->approvement_flow->decision_tree_id = null;
            $this->approvement_flow->update(); //

            $this->enable_delete_decision_tree_on = [];
            $this->workflow_decision_trees = WorkFlowDecisionTree::get();

            DB::commit();
            return session()->flash('success', __('lang.notice_successful_delete'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return session()->flash('error', 'Ocorreu um erro ao remover o fluxo selecionado');
        }
    }

    /**
     * Cancel user delete action request
     */
    public function cancel_delete_request()
    {
        $this->enable_delete_on = [];
        $this->enable_delete_decision_tree_on = [];
    }
}
