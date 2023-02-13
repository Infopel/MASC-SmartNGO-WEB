<?php

namespace App\Http\Controllers\Helpers;

use App\Models\Journals;
use App\Models\Projects;
use App\Models\CustomFields;
use App\Models\CustomValues;
use App\Models\JournalDetails;
use App\Models\User;
use App\Models\Trackers;
use Illuminate\Support\Facades\DB;

trait JornalsHelper
{
    /**
     * Helper para guardar enventos de alterações na aplicacao
     */


    public function jounalized_values_with_labels($journalized)
    {
        // dd($journalized);
        // 1 - Loop nos dados de alterações encontradas
        $journals = [];
        foreach ($journalized as $key => $journal) {
            // dd($key);
            $property = $journal['property'];
            $action = null;
            if ($journal['property'] == 'cf') {
                $custom_field = CustomFields::select('name')->where('id', $journal->prop_key)->first();
                $property = $custom_field->name;
                if ($journal->old_value !== null) {
                    $action = __('lang.text_journal_deleted', ['label' => $property, 'old' => '<del><i>' . $journal->old_value . '</i></del>']);
                } else {
                    $action = __('lang.text_journal_added', ['label' => '<b>' . $property . '</b>', 'value' => '<i>' . $journal->value . '</i>']);
                }

                if ($journal->old_value !== null && $journal->value !== null) {
                    $action = __('lang.text_journal_changed', [
                        'label' => '<b>' . $property . '</b>',
                        'old' => '<i>' . $journal->old_value . '</i>',
                        'new' => '<i>' . $journal->value . '</i>'
                    ]);
                }
            } elseif ($journal['prop_key'] == 'attr') {
                $field_name = \str_replace('_id', '', $journal['property']);
                if ($journal->old_value !== null) {
                    $action = __('lang.text_journal_changed', [
                        'label' => '<b>' . __('lang.field_' . $field_name) . '</b>',
                        'old' => '<i>' . $journal->old_value . '</i>',
                        'new' => '<i>' . $journal->value . '</i>'
                    ]);
                } else {
                    $action = __('lang.text_journal_set_to', [
                        'label' => '<b>' . __('lang.field_' . $field_name) . '</b>',
                        'value' => '<i>' . $journal->value . '</i>'
                    ]);
                }

                if ($journal->value == null) {
                    $action = __('lang.text_journal_deleted', [
                        'label' => '<b>' . __('lang.field_' . $field_name) . '</b>',
                        'old' => '<del><i>' . $journal->old_value . '</i></del>'
                    ]);
                    // dd($journal->value);
                }

                if($journal['property'] == 'is_aproved'){
                    $action_by = User::where('id', $journal->value)->withTrashed()->first();
                    $action = __('lang.text_journal_issue_report', [
                        'label' => '<b>' . __('lang.field_' . $field_name) . '</b>',
                        'action_by' => '<i>' . $action_by ? $action_by['full_name'] : 'Anonymous' . '</i>'
                    ]);
                }else if($journal['property'] == 'tracker_id'){
                    $action = __('lang.text_journal_changed', [
                        'label' => '<b>' . __('lang.field_' . $field_name) . '</b>',
                        'old' => '<i>' . Trackers::where('id', $journal->old_value)->first()->name . '</i>',
                        'new' => '<i>' . Trackers::where('id', $journal->value)->first()->name. '</i>'
                    ]);
                } else if ($journal['property'] == 'assigned_to_id') {
                    $old_value = User::where('id', $journal->old_value)->withTrashed()->first();
                    $new_value = User::where('id', $journal->value)->withTrashed()->first();
                    $action = __('lang.text_journal_changed', [
                        'label' => '<b>' . __('lang.field_' . $field_name) . '</b>',
                        'old' => '<i>' . $old_value ? $old_value['full_name'] : null . '</i>',
                        'new' => '<i>' . $new_value ? $new_value['full_name'] : null . '</i>'
                    ]);

                    if($journal->old_value == null){
                        $action = __('lang.text_journal_set_to', [
                            'label' => '<b>' . __('lang.field_' . $field_name) . '</b>',
                            'value' => '<i>' . $new_value ? $new_value['full_name'] : null . '</i>'
                        ]);
                    }
                }
            }
            $journals['' . $journal->created_on . ''][] = array(
                'id' => $journal->id,
                'journalized_id' => $journal->journalized_id,
                'journalized_type' => $journal->journalized_type,
                'notes' => $journal->notes,
                'user_id' => $journal->user_id,
                'firstname' => $journal->firstname,
                'lastname' => $journal->lastname,
                'created_on' => $journal->created_on->diffForHumans(),
                'private_notes' => $journal->private_notes,
                'prop_key' => $journal->prop_key,
                'property' => $property,
                'old_value' => $journal->old_value,
                'value' => $journal->value,
                'action' => $action
            );
        }

        // dd(array_search(key($journals), array_keys($journals)));
        // dd($journals);
        return $journals;
    }


    /**
     * Gravar change log de aleracoes de de projectos
     * @param \App\Models\Projects instance
     * @param \Illuminate\Http\Request
     */
    public function jornalize_project_changes(Projects $project)
    {

    }

    /**
     * Gravar dados de alterações de campos personalizados
     * @param \App\Models\CustomFields $Custom_fields
     * @param \App\Custom_values $Custom_fields_values
     * @return \Illuminate\Http\Response
     */
    public function jornalize_custom_fields_valeus(int $journalized_id, $old_value, $values, string $journalized_type)
    {
        try{
            DB::commit();
            // Savar actividade no journal -> para notificar usuarios
            $journal = new Journals();
            $journal->journalized_id = $journalized_id;
            $journal->journalized_type = $journalized_type;
            $journal->user_id = auth()->user()->id;
            $journal->notes = null;
            $journal->created_on = now();
            $journal->private_notes = false;
            $journal->save(); // Save data into database

            foreach ($values as $key => $custom_value) {
                $journal_details = new JournalDetails();
                $journal_details->journal_id = $journal['id'];
                $journal_details->property = 'cf';
                $journal_details->prop_key = $custom_value['custom_field_id'];
                $journal_details->old_value = $old_value;
                $journal_details->value = $custom_value['value'];
                $journal_details->save(); // Save data into database
            }
            DB::commit();
        }catch(\Throwable $th){
            DB::rollback();
        }

    }


    public function jornalize_custom_fields_valeus_removed(int $journalized_id, $old_values, $value, string $journalized_type)
    {
        try {
            DB::commit();
            // Savar actividade no journal -> para notificar usuarios
            $journal = new Journals();
            $journal->journalized_id = $journalized_id;
            $journal->journalized_type = $journalized_type;
            $journal->user_id = auth()->user()->id;
            $journal->notes = null;
            $journal->created_on = now();
            $journal->private_notes = false;
            $journal->save(); // Save data into database

            foreach ($old_values as $key => $custom_value) {
                $journal_details = new JournalDetails();
                $journal_details->journal_id = $journal['id'];
                $journal_details->property = 'cf';
                $journal_details->prop_key = $custom_value['custom_field_id'];
                $journal_details->old_value = $custom_value['value'];
                $journal_details->value = $value;
                $journal_details->save(); // Save data into database

                // Deletar custom_value
                CustomValues::where('customized_type', $journalized_type)
                    ->where('customized_id', $custom_value['customized_id'])
                    ->where('custom_field_id', $custom_value['custom_field_id'])
                    ->where('value', $custom_value['value'])
                    ->delete();
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * jornalize_attr_changes
     */
    public function jornalize_attr_changes($journalized, $new_value, $property, $journalized_type, $prop_key = 'attr', $isNote = false)
    {
        // dd($new_value);
        // Savar actividade no journal -> para notificar usuarios
        $journal = new Journals();
        $journal->journalized_id = $journalized->id;
        $journal->journalized_type = $journalized_type;
        $journal->user_id = auth()->user()->id;;
        $journal->notes = $isNote ? $new_value : null;
        $journal->created_on = now();
        $journal->private_notes = false;
        $journal->save(); // Save data into database

        // dd($journalized->getOriginal($property));
        if(!$isNote){
            $journal_details = new JournalDetails();
            $journal_details->journal_id = $journal->id;
            $journal_details->property = $property;
            $journal_details->prop_key = $prop_key;
            $journal_details->old_value = $journalized->getOriginal($property);
            $journal_details->value = $new_value;
            $journal_details->save(); // Save data into database
        }

    }
}
