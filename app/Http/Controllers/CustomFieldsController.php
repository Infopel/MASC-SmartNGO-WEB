<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\Projects;
use App\Models\CustomFields;
use Illuminate\Http\Request;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\DB;

class CustomFieldsController extends Controller
{

    protected $custom_field_users_roles;
    protected $custom_field_possible_values = null;

    protected function custom_fields_types() : array
    {
        return array(
            'IssueCustomField',
            'TimeEntryCustomField',
            'ProjectCustomField',
            'VersionCustomField',
            'DocumentCustomField',
            'UserCustomField',
            'GroupCustomField',
            'PartnerCustomField',
            'TimeEntryActivityCustomField',
            'IssuePriorityCustomField',
            'DocumentCategoryCustomField'
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $custom_fields_tabs = CustomFields::select('type')->groupby('type')->get();
        $IssueCustomField = CustomFields::select('*')->where('type', 'IssueCustomField')->orderby('position', 'asc')->get();
        $TimeEntryCustomField = CustomFields::select('*')->where('type', 'TimeEntryCustomField')->orderby('position', 'asc')->get();
        $ProjectCustomField = CustomFields::select('*')->where('type', 'ProjectCustomField')->orderby('position', 'asc')->get();
        $VersionCustomField = CustomFields::select('*')->where('type', 'VersionCustomField')->orderby('position', 'asc')->get();
        $DocumentCustomField = CustomFields::select('*')->where('type', 'DocumentCustomField')->orderby('position', 'asc')->get();
        $UserCustomField = CustomFields::select('*')->where('type', 'UserCustomField')->orderby('position', 'asc')->get();
        $GroupCustomField = CustomFields::select('*')->where('type', 'GroupCustomField')->orderby('position', 'asc')->get();
        $TimeEntryActivistomField = CustomFields::select('*')->where('type', 'TimeEntryActivistomField')->orderby('position', 'asc')->get();
        $TimeEntryActivityCustomField = CustomFields::select('*')->where('type', 'TimeEntryActivityCustomField')->orderby('position', 'asc')->get();
        $DocumentCategoryCustomField = CustomFields::select('*')->where('type', 'DocumentCategoryCustomField')->orderby('position', 'asc')->get();
        $PartnerCustomField = CustomFields::select('*')->where('type', 'PartnerCustomField')->orderby('position', 'asc')->get();

        $data = array(
            'IssueCustomField' => $IssueCustomField,
            'TimeEntryCustomField' => $TimeEntryCustomField,
            'ProjectCustomField' => $ProjectCustomField,
            'VersionCustomField' => $VersionCustomField,
            'DocumentCustomField' => $DocumentCustomField,
            'UserCustomField' => $UserCustomField,
            'GroupCustomField' => $GroupCustomField,
            'TimeEntryActivistomField' => $TimeEntryActivistomField,
            'TimeEntryActivityCustomField' => $TimeEntryActivityCustomField,
            'DocumentCategoryCustomField' => $DocumentCategoryCustomField,
            'PartnerCustomField' => $PartnerCustomField,
        );

        // return $data;

        return view('custom_fields.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('cadastrar_campos_personalizados', auth()->user())) {
            abort(401);
        }

        $type = request('type') ?? null;
        $attrib = \strtolower(\str_replace('CustomField', '', $type));
        $label = __('lang.' . "label_" . $attrib . "_plural");

        if ($attrib == 'documentcategory') {
            $label = __('lang.enumeration_doc_categories');
        }elseif ($attrib == 'issuepriority') {
            $label = __('lang.enumeration_issue_priorities');
        }elseif ($attrib == 'timeentryactivity') {
            $label = __('lang.enumeration_activities');
        }elseif ($attrib == 'timeentry') {
            $label = __('lang.project_module_time_tracking');
        }

        $is_valid_type = false;
        $is_valid_type = in_array($type , $this->custom_fields_types());

        $extra_options =  $this->extra_options($type);
        // return $extra_options;

        return view('custom_fields.new', compact('is_valid_type', 'type', 'label', 'extra_options'));
    }

    protected function extra_options($type)
    {
        if($type != 'IssueCustomField'){return [];}

        $projects = Projects::where('status', true)->get();
        $roles = Roles::select('id','name')->where('builtin', false)->get();
        $issues_type = CustomFields::select('*')->where('type', 'issues_type')->orderby('position', 'asc')->get();

        $data = array(
            'projects' => $projects,
            'roles' => $roles,
            'issues_type' => $issues_type,
        );

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('cadastrar_campos_personalizados', auth()->user())) {
            abort(401);
        }

        // Validados o request verificado se o tipo de campo personalisado e aceite pelo sistema ou nao.
        $is_valid_type = false;
        $is_valid_type = in_array($request->custom_field['type'], $this->custom_fields_types());

        if(!$is_valid_type){
            return back()->with('error', 'Econtramos um erro, o sistema nao reconhece esse tipo de campo personalisado');
        }
        // Validacao do custom_field -> name
        $request->validate([
            'custom_field.name' => 'required|unique:custom_fields,name,NULL,id,type,'.$request->custom_field['type']
            ],[
                'required' => __('lang.custom_field_name_required'),
                'unique' => __('lang.errors.messages.taken', ['attribute' => __('lang.field_name')])
        ]);

        // defining default values
        $_possible_values = [];
        $possible_values = null;

        /** List format type */
        if($request->custom_field['field_format'] == 'list'){
            $_possible_values = explode("\n", str_replace("\r", "", $request->custom_field['possible_values']));
            $possible_values = Yaml::dump($_possible_values);
        }
        /** User format type */
        if($request->custom_field['field_format'] == 'user'){
            $users_role = explode("\n", str_replace("\r", "", $request->custom_field['user_role']));
            $this->custom_field_users_roles = Yaml::dump($users_role);
        }


        // return $possible_values;
        $possible_values = $this->custom_field_possible_values($request->custom_field['field_format'], $request);
        $format_store = Yaml::dump($this->custom_field_format_store($request->custom_field['field_format'], $request));

        // return Yaml::parse($format_store);
        // return $request;
        // iniciar o cadastro do campo personalizado
        try {

            DB::beginTransaction();

            $custom_field = new CustomFields();
            $position = CustomFields::select('position')->latest('id')->first()->position ?? 0;

            $custom_field->type = $request->custom_field['type'];
            $custom_field->name = $request->custom_field['name'];
            $custom_field->field_format = $request->custom_field['field_format'];
            $custom_field->possible_values = $possible_values;
            $custom_field->regexp = $request->custom_field['regexp'] ?? null;
            $custom_field->min_length = $request->custom_field['min_length'] ?? null;
            $custom_field->max_length = $request->custom_field['max_length'] ?? null;
            $custom_field->is_required = $request->custom_field['is_required'] ?? 0;
            $custom_field->is_for_all = $request->custom_field['is_for_all'] ?? 0;
            $custom_field->is_filter = $request->custom_field['is_filter'] ?? 0;
            $custom_field->position = ++$position;
            $custom_field->searchable = $request->custom_field['searchable'] ?? 0;
            $custom_field->default_value = $request->custom_field['default_value'] ?? null;
            $custom_field->editable = $request->custom_field['editable'] ?? 1;
            $custom_field->visible = $request->custom_field['visible'] ?? 1;
            $custom_field->multiple = $request->custom_field['multiple'] ?? 0;
            $custom_field->format_store = $format_store ?? null;
            $custom_field->description = $request->custom_field['description'] ?? null;

            $custom_field->save();

            DB::commit();

            return redirect()->route('custom_fields.edit', ['custom_field' => $custom_field->id ])->with('success', __('lang.notice_successful_create'));
        } catch (\Throwable $th) {
            // throw $th;
            // return $th->getMessage();
            DB::rollback();
            return back()->with('error', 'Os dados nao foram cadastrados Encontramos um erro. Error Type [RF002] - CustomFields!');
        }
        return $request;
    }

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
    protected function custom_field_possible_values($field_format, $request)
    {
        switch ($field_format) {
            case 'list':
                $_possible_values = explode("\n", str_replace("\r", "", $request->custom_field['possible_values']));
                $possible_values = Yaml::dump($_possible_values);
                return $possible_values;
                break;

            case 'enumeration':
                $_possible_values = explode("\n", str_replace("\r", "", $request->custom_field['possible_values']));
                return Yaml::dump($_possible_values);
                break;

            case 'user':
                $users_role = explode("\n", str_replace("\r", "", $request->custom_field['user_role']));
                $this->custom_field_users_roles = Yaml::dump($users_role);
                return $this->custom_field_users_roles;
                break;

            default:
                return null;
                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomFields  $customFields
     * @return \Illuminate\Http\Response
     */
    public function show(CustomFields $custom_field)
    {
        return $custom_field;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomFields  $customFields
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomFields $custom_field)
    {

        if(!auth()->user()->can('editar_campos_personalizados', auth()->user())){
            abort(401);
        }

        $attrib = \strtolower(\str_replace('CustomField', '', $custom_field->type));
        $label = __('lang.' . "label_" . $attrib . "_plural");

        $custom_field->format_store = Yaml::parse($custom_field->format_store);
        $custom_field->possible_values = str_replace('- ', '', $custom_field->possible_values);
        $custom_field->possible_values = str_replace('\'', '', $custom_field->possible_values);
        // return $custom_field;
        return view('custom_fields.edit', compact('custom_field', 'label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomFields  $customFields
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomFields $custom_field)
    {
        if (!auth()->user()->can('editar_campos_personalizados', auth()->user())) {
            abort(401);
        }

        $format_store = Yaml::dump($this->custom_field_format_store($request->custom_field['field_format'], $request));
        $possible_values = $this->custom_field_possible_values($custom_field->field_format, $request);

        try {

            $custom_field->name = $request->custom_field['name'];
            $custom_field->possible_values = $possible_values;
            $custom_field->regexp = $request->custom_field['regexp'] ?? $custom_field->regexp;
            $custom_field->min_length = $request->custom_field['min_length'] ?? $custom_field->min_length;
            $custom_field->max_length = $request->custom_field['max_length'] ?? $custom_field->max_length;
            $custom_field->is_required = $request->custom_field['is_required'] ?? $custom_field->is_required;
            $custom_field->is_for_all = $request->custom_field['is_for_all'] ?? $custom_field->is_for_all;
            $custom_field->is_filter = $request->custom_field['is_filter'] ?? $custom_field->is_filter;
            $custom_field->searchable = $request->custom_field['searchable'] ?? $custom_field->searchable;
            $custom_field->default_value = $request->custom_field['default_value'] ?? $custom_field->default_value;
            $custom_field->editable = $request->custom_field['editable'] ?? $custom_field->editable;
            $custom_field->visible = $request->custom_field['visible'] ?? $custom_field->visible;
            $custom_field->multiple = $request->custom_field['multiple'] ?? $custom_field->multiple;
            $custom_field->format_store = $format_store;
            $custom_field->description = $request->custom_field['description'] ?? $custom_field->description;


            $custom_field->update();
            return redirect()->route('custom_fields.edit', ['custom_field' => $custom_field->id])->with('success', __('lang.notice_successful_update'));

        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Os dados nao foram cadastrados Encontramos um erro. Error Type [RF002] - CustomFields!');
        }

    }

    /**
     * Remove resource request
     * Confirmar remocao de um custom_field
     */
    public function delete_request(CustomFields $custom_field)
    {
        if (!auth()->user()->can('excluir_campos_personalizado', auth()->user())) {
            abort(401);
        }

        return back()->with('isRemoveTrue', [
            'msg' => __('lang.text_are_you_sure'),
            'custom_field_id' => $custom_field->id,
            'custom_field_name' => $custom_field->name,
            'custom_field_type' => __('lang.label_field_format_'.$custom_field->type)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomFields  $customFields
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomFields $custom_field)
    {
        if (!auth()->user()->can('excluir_campos_personalizados', auth()->user())) {
            abort(401);
        }

        try {
            $custom_field->delete();
            return back()->with('success', __('lang.notice_successful_delete'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
