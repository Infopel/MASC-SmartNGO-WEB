<?php

namespace App\Http\Controllers\Helpers;

use App\Models\CustomValues;
use Symfony\Component\Yaml\Yaml;
use App\Http\Controllers\Helpers\JornalsHelper;


trait CustomFieldsHelper
{
    use JornalsHelper;
    /**
     * Creating the store formart
     * @return array
     */
    protected function custom_field_format_store($field_format, $request)
    {
        switch ($field_format) {
            case 'attachment':
                return $_format_store = array(
                    'extensions_allowed' => $request->custom_field['extensions_allowed'] ?? '',
                );
                break;

            case 'bool':
                return $_format_store = array(
                    'url_pattern' => $request->custom_field['url_pattern'] ?? '',
                    'edit_tag_style' => $request->custom_field['edit_tag_style'] ?? '',
                );
                break;

            case 'enumeration':
                return $_format_store = array(
                    'url_pattern' => $request->custom_field['url_pattern'] ?? '',
                    'edit_tag_style' => $request->custom_field['edit_tag_style'] ?? '',
                );
                break;

            case 'list':
                return $_format_store = array(
                    'url_pattern' => $request->custom_field['url_pattern'] ?? '',
                    'edit_tag_style' => $request->custom_field['edit_tag_style'] ?? '',
                );
                break;

            case 'string':
                return $_format_store = array(
                    'text_formatting' => $request->custom_field['text_formatting'] ?? '',
                    'url_pattern' => $request->custom_field['url_pattern'] ?? '',
                );
                break;

            case 'text':
                return $_format_store = array(
                    'text_formatting' => $request->custom_field['text_formatting'] ?? '',
                    'full_width_layout' => $request->custom_field['full_width_layout'] ?? '',
                );
                break;

            case 'user':
                return $_format_store = array(
                    'user_role' => $this->custom_field_users_roles,
                    'edit_tag_style' => $request->custom_field['full_width_layout'] ?? '',
                );
                break;

            default:
                return $_format_store = array(
                    'url_pattern' => $request->custom_field['url_pattern'] ?? '',
                );
                break;
        }
    }

    /**
     * Custom_field possible_values
     * @return String
     */
    protected function custom_field_possible_values($field_format, $possible_values)
    {
        switch ($field_format) {
            case 'list':
                $_possible_values = explode("\n", str_replace("\r", "", $possible_values));
                $possible_values = Yaml::dump($_possible_values);
                return $possible_values;
                break;

            case 'enumeration':
                $_possible_values = explode("\n", str_replace("\r", "", $possible_values));
                return Yaml::dump($_possible_values);
                break;

            case 'user':
                $users_role = explode("\n", str_replace("\r", "", $possible_values));
                $this->custom_field_users_roles = Yaml::dump($users_role);
                return $this->custom_field_users_roles;
                break;

            default:
                return null;
                break;
        }
    }

    /**
     * Return custom_fields_values
     * Return custom field tag with its label tag
     */
    public function custom_field_tag_with_label($customized_id = null, $custom_values = [], $custom_fields = null)
    {
        $user_custom_fildes_values = array();
        foreach ($custom_values as $custom_value){
            if ($custom_value['custom_field'] !== null){
                $user_custom_fildes_values[$custom_value['custom_field']['name']][] = array(
                    'id' => $custom_value['id'],
                    'value' => $custom_value['value'],
                    'custom_field_id' => $custom_value['custom_field_id'],
                    'customized_id' => $custom_value['customized_id'],
                );
            }
        }



        $possible_values = array();
        $is_checked = true;
        foreach ($custom_fields as $key => $custom_field){
            if($custom_field['field_format'] == 'list'){
                foreach (Yaml::parse($custom_field['possible_values'] ?? 'undefined_possible_value') as $cf_possible_values) {

                    if(isset($user_custom_fildes_values[$custom_field['name']])){
                        $user_custom_values = \array_column($user_custom_fildes_values[$custom_field['name']], 'value');
                        $possible_values[$custom_field['name']]['field_format'] = $custom_field['field_format'];
                        $possible_values[$custom_field['name']]['format_store'] = Yaml::parse($custom_field['format_store'] ?? '');
                        $possible_values[$custom_field['name']]['multiple'] = $custom_field['multiple'];

                        if (in_array($cf_possible_values, $user_custom_values)){
                            $possible_values[$custom_field['name']]['values'][] = array(
                                'custom_value_id' => $user_custom_fildes_values[$custom_field['name']][0]['id'],
                                'custom_field_id' => $custom_field['id'],
                                'customized_id' => $user_custom_fildes_values[$custom_field['name']][0]['customized_id'],
                                'value' => $cf_possible_values,
                                'is_selected' => true,
                            );
                        }else{
                            $possible_values[$custom_field['name']]['values'][] = array(
                                'custom_value_id' => $user_custom_fildes_values[$custom_field['name']][0]['id'],
                                'custom_field_id' => $custom_field['id'],
                                'customized_id' => $user_custom_fildes_values[$custom_field['name']][0]['customized_id'],
                                'value' => $cf_possible_values,
                                'is_selected' => false,
                            );
                        }
                    }else{
                        $possible_values[$custom_field['name']]['field_format'] = $custom_field['field_format'];
                        $possible_values[$custom_field['name']]['format_store'] = Yaml::parse($custom_field['format_store'] ?? '');
                        $possible_values[$custom_field['name']]['multiple'] = $custom_field['multiple'];
                        $possible_values[$custom_field['name']]['values'][] = array(
                            'custom_value_id' => null,
                            'custom_field_id' => $custom_field['id'],
                            'customized_id' => null,
                            'value' => $cf_possible_values,
                            'is_selected' => false,
                        );
                    }
                }
            }else{
                $possible_values[$custom_field['name']]['field_format'] = $custom_field['field_format'];
                $possible_values[$custom_field['name']]['format_store'] = Yaml::parse($custom_field['format_store'] ?? '');
                $possible_values[$custom_field['name']]['multiple'] = $custom_field['multiple'];
                $possible_values[$custom_field['name']]['values'][] = array(
                    'custom_value_id' => null,
                    'custom_field_id' => $custom_field['id'],
                    'customized_id' => null,
                    'value' => CustomValues::where('custom_field_id', $custom_field['id'])->where('customized_id', $customized_id)->first()->value ?? null,
                );
            }
        }
        return $possible_values;
    }


    /**
     * Cadastro de dados nos campos personalizados
     */
    protected function store_custom_fildes_values($custom_field_values, $customized_id, $customized_type)
    {
        foreach ($custom_field_values as $field => $value) {
            if (\is_array($value)) {
                foreach ($value as $cv_value) {
                    if ($cv_value == null) {
                    } else {
                        // Performe save query
                        $custom_values = new CustomValues();
                        $custom_values->customized_type = $customized_type;
                        $custom_values->customized_id = $customized_id;
                        $custom_values->custom_field_id = $field;
                        $custom_values->value = $cv_value;
                        $custom_values->save(); // Save data into database
                    }
                }
            } else {
                $custom_values = new CustomValues();
                $custom_values->customized_type = $customized_type;
                $custom_values->customized_id = $customized_id;
                $custom_values->custom_field_id = $field;
                $custom_values->value = $value;
                $custom_values->save(); // Save data into database

                // dd($value);

            }
        }
    }


    /**
     * Atualzar campos personalizados de projects
     */
    protected function update_project_custom_fildes_values($custom_field_values, $customized_id, $customized_type)
    {
        foreach ($custom_field_values as $field => $value) {
            if (\is_array($value)) {
                CustomValues::where('customized_type', $customized_type)
                    ->where('customized_id', $customized_id)
                    ->where('custom_field_id', $field)
                    ->delete();
                foreach ($value as $cv_value) {
                    if ($cv_value == null) {
                    } else {
                        $avalible_custom_value = CustomValues::where('customized_type', $customized_type)
                            ->where('customized_id', $customized_id)
                            ->where('custom_field_id', $field)
                            ->where('value', $cv_value)
                            ->first();
                        if ($avalible_custom_value) {
                            // return 'We found data with the same value as you request';
                        } else {
                            // Performe save query
                            $custom_values = new CustomValues();
                            $custom_values->customized_type = $customized_type;
                            $custom_values->customized_id = $customized_id;
                            $custom_values->custom_field_id = $field;
                            $custom_values->value = $cv_value;
                            $custom_values->save(); // Save data into database
                        }
                    }
                }
            } else {
                // Performe save query
                $custom_values = CustomValues::where('customized_type', $customized_type)
                    ->where('customized_id', $customized_id)
                    ->where('custom_field_id', $field)
                    ->first();
                if ($custom_values) {
                    if ($custom_values->value != $value) {
                        $custom_values->value = $value;
                        $custom_values->update(); // Save data into database
                    }
                } else {
                    $custom_values = new CustomValues();
                    $custom_values->customized_type = $customized_type;
                    $custom_values->customized_id = $customized_id;
                    $custom_values->custom_field_id = $field;
                    $custom_values->value = $value;
                    $custom_values->save(); // Save data into database
                }
            }
        }
    }

    /**
     * Update de dados nos campos personalizados
     */
    protected function update_custom_fildes_values($custom_field_values, $customized_id, $customized_type)
    {
        foreach ($custom_field_values as $field => $value) {
            $values_to_jornalize = [];
            if (\is_array($value)) {
                foreach ($value as $cv_value) {
                    if ($cv_value == null) {
                    } else {
                        $avalible_custom_value = CustomValues::where('customized_type', $customized_type)
                            ->where('customized_id', $customized_id)
                            ->where('custom_field_id', $field)
                            ->where('value', $cv_value)
                            ->first();
                        if ($avalible_custom_value) {
                            // return 'We found data with the same value as you request';
                        } else {
                            // return $cv_value;
                            $values_to_jornalize[] = array(
                                'customized_id' => $customized_id,
                                'custom_field_id' => $field,
                                'value' => $cv_value,
                            );

                            // Performe save query
                            $custom_values = new CustomValues();
                            $custom_values->customized_type = $customized_type;
                            $custom_values->customized_id = $customized_id;
                            $custom_values->custom_field_id = $field;
                            $custom_values->value = $cv_value;
                            $custom_values->save(); // Save data into database
                        }
                    }
                }

                $value = array_filter($value);
                $unselected_values = CustomValues::where('customized_type', $customized_type)
                    ->where('customized_id', $customized_id)
                    ->where('custom_field_id', $field)
                    ->whereNotIn('value', $value)->get()->toArray();

                if (sizeof($unselected_values) > 0) {
                    $this->jornalize_custom_fields_valeus_removed(
                        $customized_id,
                        $unselected_values,
                        null,
                        $customized_type
                    );
                }
                // dd($values_to_jornalize);
                if($values_to_jornalize != []){
                    $this->jornalize_custom_fields_valeus(
                        $customized_id,
                        null,
                        $values_to_jornalize,
                        $customized_type
                    );
                }
            } else {
                // Performe save query
                $custom_values = CustomValues::where('customized_type', $customized_type)
                    ->where('customized_id', $customized_id)
                    ->where('custom_field_id', $field)
                    ->first();

                $values_to_jornalize[] = array(
                    'customized_id' => $customized_id,
                    'custom_field_id' => $field,
                    'value' => $value,
                );

                if ($custom_values) {
                    if($custom_values->value != $value){
                        $this->jornalize_custom_fields_valeus(
                            $customized_id,
                            $custom_values->value,
                            $values_to_jornalize,
                            $customized_type
                        );
                        $custom_values->value = $value;
                        $custom_values->update(); // Save data into database
                    }
                } else {
                    $custom_values = new CustomValues();
                    $custom_values->customized_type = $customized_type;
                    $custom_values->customized_id = $customized_id;
                    $custom_values->custom_field_id = $field;
                    $custom_values->value = $value;
                    $custom_values->save(); // Save data into database

                    $this->jornalize_custom_fields_valeus(
                        $customized_id,
                        null,
                        $values_to_jornalize,
                        $customized_type
                    );
                }
            }
        }
    }
}
