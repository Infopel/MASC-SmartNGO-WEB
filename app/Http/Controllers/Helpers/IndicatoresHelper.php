<?php

namespace App\Http\Controllers\Helpers;

use App\Models\IndicatorFields;
use App\Models\IndicatorFieldsIssues;
use App\Models\IndicatorFieldsValues;
use App\Models\IndicatorRelation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait IndicatoresHelper
{

    protected $query;
    protected $issue_subject;
    protected $issue_id;

    /**
     * Return Indicators with label n values
     */
    public function available_indicatores($type = "Issue")
    {
        return IndicatorFields::where('type', $type)->get();
    }


    public function validate_indicator_fields_request(array $indicator_fields)
    {
        if (sizeof($indicator_fields) <= 0) {
            throw ValidationException::withMessages(['Inidcadores' => 'Uma tarefa deve ter pelo menos um indicador!']);
        }
        foreach ($indicator_fields as $indicator_field) {
            // dd($indicator_field);
            Validator::make($indicator_field, [
                'name' => 'required',
                'type' => 'required|int|max:1',
                'is_new' => 'required|int|max:1',
                'meta.type' => 'required',
                'meta.value' => 'required',
                'fonte_ver' => 'required',
                'base_ref' => 'required',
            ], [
                'required' => __('lang.errors.messages.required'),
                'is_new.required' => __('Estado do inidicador Infefinido (Fatal Error! Contacte o Admin)'),
            ], [
                'name' => __('Nome do Inidcador (Indicador)'),
                'type' => __('Tipo de Inidcador (Indicador)'),
                'meta.type' => __('Tipo de Meta (Indicador)'),
                'name.value' => __('Meta (Indicador)'),
                'fonte_ver' => __('Fonte de Verificação (Indicador)'),
                'base_ref' => __('Base de referência (Indicador)'),
                'is_new' => __('(Fatal Error! Contacte o Admin)'),
            ])->validate();
        }
    }


    /**
     * Store Indicators
     */
    public function store_indicators_fildes(array $indicator_fields, $customized_id, $tracker_id = null, $customized_type, $project_type)
    {

        if ($project_type == 'PDE') {
            $is_parent = true;
        } else {
            $is_parent = false;
        }

        // Loop all avalible indicator_fields
        foreach ($indicator_fields as $ind_field) {
            if ($ind_field['name'] !== null) {

                try {

                    DB::beginTransaction();
                    // 1 - Gravar os dados do indicador
                    $indicator_field = new IndicatorFields();
                    $indicator_field->type = $customized_type;
                    $indicator_field->name = $ind_field['name'];
                    $indicator_field->is_cumulative = $ind_field['type'] ?? 0;
                    $indicator_field->category = $tracker_id;
                    $indicator_field->is_parent = $is_parent;
                    $indicator_field->created_on = now();
                    $indicator_field->updated_on = now();
                    $indicator_field->save(); // Save data into database

                    // 2 - strore Belong to
                    $belongsTo = new IndicatorFieldsIssues();
                    $belongsTo->indicator_fields_id = $indicator_field->id;
                    $belongsTo->issue_id = $customized_id;
                    $belongsTo->save(); // Save data into database


                    if (isset($ind_field['parent_id'])) {
                        IndicatorRelation::where('parent', $ind_field['parent_id'])->where('child', $indicator_field->id)->forcedelete();

                        $indicator_field_relation = new IndicatorRelation();
                        $indicator_field_relation->parent = $ind_field['parent_id'];
                        $indicator_field_relation->pri_parent = $ind_field['pri_parent_id'] ?? null;
                        $indicator_field_relation->child = $indicator_field->id;
                        $indicator_field_relation->relationed_by = $customized_id;
                        $indicator_field_relation->created_on = now();

                        $indicator_field_relation->save(); // Save data into database
                    }

                    // 3 Save Indicator default values
                    $indicator_field_values = new IndicatorFieldsValues();
                    $indicator_field_values->indicator_type = $indicator_field->type;
                    $indicator_field_values->indicator_field_id = $indicator_field->id;
                    $indicator_field_values->customized_id = $customized_id;
                    $indicator_field_values->value = null;
                    $indicator_field_values->meta_type = $ind_field['meta']['type'];
                    $indicator_field_values->meta = $ind_field['meta']['value'];
                    $indicator_field_values->m_trim_01 = $ind_field['meta']['trim_01'] ?? 0;
                    $indicator_field_values->m_trim_02 = $ind_field['meta']['trim_02'] ?? 0;
                    $indicator_field_values->m_trim_03 = $ind_field['meta']['trim_03'] ?? 0;
                    $indicator_field_values->m_trim_04 = $ind_field['meta']['trim_04'] ?? 0;
                    $indicator_field_values->fonte_ver = $ind_field['fonte_ver'];
                    $indicator_field_values->base_ref = $ind_field['base_ref'];
                    $indicator_field_values->created_on = now();
                    $indicator_field_values->updated_on = now();

                    $indicator_field_values->save(); // Save data into database

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollback();
                    throw $th;
                }
            }
        }
        // return true;
    }

    /**
     * deleted_indicators
     */
    public function deleted_indicators($deleted_indicators, $customized_id, $customized_type)
    {
        foreach (explode(',', $deleted_indicators) as $deleted_indicator_id) {
            if ($deleted_indicator_id != null || $deleted_indicator_id != "") {
                $indicator_field = IndicatorFields::where('id', $deleted_indicator_id)->first();
                IndicatorFieldsValues::where('indicator_field_id', $indicator_field['id'])
                    ->where('customized_id', $customized_id)
                    ->where('indicator_type', $customized_type)
                    ->delete();

                IndicatorFieldsIssues::where('issue_id', $customized_id)->where('indicator_fields_id', $indicator_field['id'])->forcedelete();
                IndicatorRelation::where('parent', $indicator_field['id'])->orWhere('child', $indicator_field['id'])->delete();
                $indicator_field->delete(); // delete
            }
        }
    }

    /**
     * Store Indicators values
     */
    public function update_indicators_fildes_values(array $indicator_fields, $customized_id, $tracker_id = null, $customized_type, $project_type)
    {
        // dd($indicator_fields);
        foreach ($indicator_fields as $ind_field) {
            try {
                DB::beginTransaction();

                if ($ind_field['is_new'] == '1') {
                    $this->store_indicators_fildes(array($ind_field), $customized_id, $tracker_id, $customized_type, $project_type);
                } else {
                    // 1 - Atualizar os dados do indicador
                    $indicator_field = IndicatorFields::where('id', $ind_field['indicator_id'])->first();
                    if ($indicator_field) {
                        $indicator_field_values = IndicatorFieldsValues::where('indicator_field_id', $indicator_field->id)
                            ->where('customized_id', '=', $customized_id)
                            ->first();


                        // dd($ind_field['name']);
                        if ($indicator_field->name !== $ind_field['name']) {
                            $indicator_field->name =  $ind_field['name'];
                        }
                        if ($indicator_field->is_cumulative !== $ind_field['type']) {
                            $indicator_field->is_cumulative = $ind_field['type'];
                        }
                        $indicator_field->updated_on = now();
                        $indicator_field->update(); // Save data into database

                        if (isset($ind_field['parent_id'])) {
                            IndicatorRelation::where('parent', $ind_field['parent_id'])->where('child', $indicator_field->id)->forcedelete();

                            $indicator_field_relation = new IndicatorRelation();
                            $indicator_field_relation->parent = $ind_field['parent_id'];
                            $indicator_field_relation->pri_parent = $ind_field['pri_parent_id'] ?? null;
                            $indicator_field_relation->child = $indicator_field->id;
                            $indicator_field_relation->relationed_by = $customized_id;
                            $indicator_field_relation->created_on = now();

                            $indicator_field_relation->save(); // Save data into database
                        }

                        // 3 Update Indicator default values
                        $indicator_field_values->meta = $ind_field['meta']['value'];
                        $indicator_field_values->meta_type = $ind_field['meta']['type'];
                        $indicator_field_values->m_trim_01 = $ind_field['meta']['trim_01'] ?? 0;
                        $indicator_field_values->m_trim_02 = $ind_field['meta']['trim_02'] ?? 0;
                        $indicator_field_values->m_trim_03 = $ind_field['meta']['trim_03'] ?? 0;
                        $indicator_field_values->m_trim_04 = $ind_field['meta']['trim_04'] ?? 0;
                        $indicator_field_values->fonte_ver = $ind_field['fonte_ver'];
                        $indicator_field_values->base_ref = $ind_field['base_ref'];
                        $indicator_field_values->updated_on = now();

                        $indicator_field_values->update(); // Save data into database
                    }
                }
                DB::commit();
            } catch (\Throwable $th) {
                throw $th;
                DB::rollback();
            }
        }
    }

    /**
     * search indicadores do PDE
     */
    public function search_indicator_parant($query)
    {
        if ($query !== null || $query == ' ') {
            return [];
        }
        return IndicatorFields::where(function ($q) use ($query) {
            $q->where('name', 'like', '%' . $query . '%')->orWhere('id', 'like', '%' . $query . '%');
        })->where('is_parent', true)->get()->toArray();
    }

    public function sear()
    {
    }
}
