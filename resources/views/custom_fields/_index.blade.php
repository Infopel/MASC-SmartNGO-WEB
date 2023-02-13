<nav>
    <div class="nav nav-tabs mb-2" id="nav-tab" role="tablist">

        @if (\sizeOf($data['IssueCustomField']) > 0)
        <a class="nav-item nav-link link-option active" id="IssueCustomField" data-toggle="tab" href="#tab-IssueCustomField" role="tab" aria-controls="tab-IssueCustomField" aria-selected="true">{{ __('lang.label_issue_plural') }}</a>
        @endif
        @if (\sizeOf($data['TimeEntryCustomField']) > 0)
            <a  class="nav-item nav-link link-option" id="TimeEntryCustomField" data-toggle="tab" href="#tab-TimeEntryCustomField" role="tab" aria-controls="tab-TimeEntryCustomField" aria-selected="true">{{ __('lang.project_module_time_tracking') }}</a>
        @endif
        @if (\sizeOf($data['ProjectCustomField']) > 0)
            <a class="nav-item nav-link link-option" id="ProjectCustomField" data-toggle="tab" href="#tab-ProjectCustomField" role="tab" aria-controls="tab-ProjectCustomField" aria-sted="true">{{ __('lang.label_project_plural') }}</a>
        @endif
        @if (\sizeOf($data['VersionCustomField']) > 0)
            <a class="nav-item nav-link link-option" id="VersionCustomField" data-toggle="tab" href="#tab-VersionCustomField" role="tab" aria-controls="tab-VersionCustomField" aria-sted="true">{{ __('lang.label_version_plural') }}</a>
        @endif
        @if (\sizeOf($data['DocumentCustomField']) > 0)
            <a class="nav-item nav-link link-option" id="DocumentCustomField" data-toggle="tab" href="#tab-DocumentCustomField" role="tab" aria-controls="tab-DocumentCustomField" aria-cted="true">{{ __('lang.label_document_plural') }}</a>
        @endif
        @if (\sizeOf($data['UserCustomField']) > 0)
            <a class="nav-item nav-link link-option" id="UserCustomField" data-toggle="tab" href="#tab-UserCustomField" role="tab" aria-controls="tab-UserCustomField" aria-sele="true">{{ __('lang.label_user_plural') }}</a>
        @endif
        @if (\sizeOf($data['GroupCustomField']) > 0)
            <a class="nav-item nav-link link-option" id="GroupCustomField" data-toggle="tab" href="#tab-GroupCustomField" role="tab" aria-controls="tab-GroupCustomField" aria-seld="true">{{ __('lang.label_group_plural') }}</a>
        @endif
        @if (\sizeOf($data['PartnerCustomField']) > 0)
            <a class="nav-item nav-link link-option" id="PartnerCustomField" data-toggle="tab" href="#tab-PartnerCustomField" role="tab" aria-controls="tab-PartnerCustomField" aria-seld="true">{{ __('lang.label_partner_plural') }}</a>
        @endif
        @if (\sizeOf($data['TimeEntryActivityCustomField']) > 0)
            <a class="nav-item nav-link link-option" id="TimeEntryActivityCustomField" data-toggle="tab" href="#tab-TimeEntryActivityCustomField" role="tab" aria-controls="tab-TimeEntryActivityCustomField" aria-selected="true">{{ __('lang.enumeration_activities') }}</a>
        @endif
        @if (\sizeOf($data['DocumentCategoryCustomField']) > 0)
            <a class="nav-item nav-link link-option" id="DocumentCategoryCustomField" data-toggle="tab" href="#tab-DocumentCategoryCustomField" role="tab" aria-controls="tab-DocumentCategoryCustomField" aria-selected="true">{{ __('lang.enumeration_doc_categories') }}</a>
        @endif
    </div>
</nav>

<div class="tab-content table-responsive" id="nav-tabContent">
    <div class="tab-pane fade show active" id="tab-IssueCustomField" role="tabpanel" aria-labelledby="IssueCustomField">
        <table class="table table-sm nowrap table-hover table-striped">
            <thead class="table-active text-center">
                <th class="p-0 pl-2 pr-2">Nome</th>
                <th class="p-0 pl-2 pr-2">Formato</th>
                <th class="p-0 pl-2 pr-2">Obrigatorio</th>
                <th class="p-0 pl-2 pr-2">Para todos os projectos</th>
                <th class="p-0 pl-2 pr-2">usado por</th>
                @can('excluir_campos_personalizados', App\Models\User::class)
                    <th class="p-0 pl-2 pr-2 text-nowrap"></th>
                @endcan
            </thead>

            <tbody>
                @foreach ($data['IssueCustomField'] as $item)
                    <tr>
                        <td class="p-0 pl-2 pr-2">
                            <a href="{{ route('custom_fields.edit', ['custom_field' => $item->id ]) }}">{{  $item->name   }}</a>
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            {{ __('lang.label_field_format_'.$item->field_format) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if ($item->is_required)
                                <i class="icon-checkmark-circle text-success"></i>
                            @endif
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if ($item->is_for_all)
                                <i class="icon-checkmark-circle text-success"></i>
                            @endif
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if (!$item->is_for_all)
                                {{ __('lang.label_x_projects.zero') }}
                            @endif
                        </td>
                        @can('excluir_campos_personalizados', App\Models\User::class)
                            <td class="p-0 pl-2 pr-2 text-right text-nowrap">
                                <a class="" href="{{ route('custom_fields.delete_request', ['custom_field' => $item->id]) }}">
                                    <i class="icon-trash"></i>
                                    {{ __('lang.button_delete') }}
                                </a>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="tab-pane fade" id="tab-TimeEntryCustomField" role="tabpanel" aria-labelledby="TimeEntryCustomField">
        <table class="table table-sm nowrap table-hover table-striped">
            <thead class="table-active text-center">
                <th class="p-0 pl-2 pr-2">Nome</th>
                <th class="p-0 pl-2 pr-2">Formato</th>
                <th class="p-0 pl-2 pr-2">Obrigatorio</th>
                <th class="p-0 pl-2 pr-2">Para todos os projectos</th>
                <th class="p-0 pl-2 pr-2">usado por</th>
                @can('excluir_campos_personalizados', App\Models\User::class)
                    <th class="p-0 pl-2 pr-2 text-nowrap"></th>
                @endcan
            </thead>

            <tbody>
                @foreach ($data['TimeEntryCustomField'] as $item)
                    <tr>
                        <td class="p-0 pl-2 pr-2">
                            <a href="{{ route('custom_fields.edit', ['custom_field' => $item->id ]) }}">{{  $item->name   }}</a>
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            {{ __('lang.label_field_format_'.$item->field_format) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if ($item->is_required)
                                <i class="icon-checkmark-circle text-success"></i>
                            @endif
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if ($item->is_for_all)
                                <i class="icon-checkmark-circle text-success"></i>
                            @endif
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if (!$item->is_for_all)
                                {{ __('lang.label_x_projects.zero') }}
                            @endif
                        </td>
                        @can('excluir_campos_personalizados', App\Models\User::class)
                            <td class="p-0 pl-2 pr-2 text-right text-nowrap">
                                <a class="" href="{{ route('custom_fields.delete_request', ['custom_field' => $item->id]) }}">
                                    <i class="icon-trash"></i>
                                    {{ __('lang.button_delete') }}
                                </a>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="tab-pane fade" id="tab-ProjectCustomField" role="tabpanel" aria-labelledby="ProjectCustomField">
        <table class="table table-sm nowrap table-hover table-striped">
            <thead class="table-active text-center">
                <th class="p-0 pl-2 pr-2">Nome</th>
                <th class="p-0 pl-2 pr-2">Formato</th>
                <th class="p-0 pl-2 pr-2">Obrigatorio</th>
                <th class="p-0 pl-2 pr-2">Para todos os projectos</th>
                <th class="p-0 pl-2 pr-2">usado por</th>
                @can('excluir_campos_personalizados', App\Models\User::class)
                    <th class="p-0 pl-2 pr-2 text-nowrap"></th>
                @endcan
            </thead>

            <tbody>
                @foreach ($data['ProjectCustomField'] as $item)
                    <tr>
                        <td class="p-0 pl-2 pr-2">
                            <a href="{{ route('custom_fields.edit', ['custom_field' => $item->id ]) }}">{{  $item->name   }}</a>
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            {{ __('lang.label_field_format_'.$item->field_format) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if ($item->is_required)
                                <i class="icon-checkmark-circle text-success"></i>
                            @endif
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if ($item->is_for_all)
                                <i class="icon-checkmark-circle text-success"></i>
                            @endif
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if (!$item->is_for_all)
                                {{ __('lang.label_x_projects.zero') }}
                            @endif
                        </td>
                        @can('excluir_campos_personalizados', App\Models\User::class)
                            <td class="p-0 pl-2 pr-2 text-right text-nowrap">
                                <a class="" href="{{ route('custom_fields.delete_request', ['custom_field' => $item->id]) }}">
                                    <i class="icon-trash"></i>
                                    {{ __('lang.button_delete') }}
                                </a>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="tab-pane fade" id="tab-VersionCustomField" role="tabpanel" aria-labelledby="VersionCustomField">
        <table class="table table-sm nowrap table-hover table-striped">
            <thead class="table-active text-center">
                <th class="p-0 pl-2 pr-2">Nome</th>
                <th class="p-0 pl-2 pr-2">Formato</th>
                <th class="p-0 pl-2 pr-2">Obrigatorio</th>
                <th class="p-0 pl-2 pr-2">Para todos os projectos</th>
                <th class="p-0 pl-2 pr-2">usado por</th>
                @can('excluir_campos_personalizados', App\Models\User::class)
                    <th class="p-0 pl-2 pr-2 text-nowrap"></th>
                @endcan
            </thead>

            <tbody>
                @foreach ($data['VersionCustomField'] as $item)
                    <tr>
                        <td class="p-0 pl-2 pr-2">
                            <a href="{{ route('custom_fields.edit', ['custom_field' => $item->id ]) }}">{{  $item->name   }}</a>
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            {{ __('lang.label_field_format_'.$item->field_format) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if ($item->is_required)
                                <i class="icon-checkmark-circle text-success"></i>
                            @endif
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if ($item->is_for_all)
                                <i class="icon-checkmark-circle text-success"></i>
                            @endif
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if (!$item->is_for_all)
                                {{ __('lang.label_x_projects.zero') }}
                            @endif
                        </td>
                        @can('excluir_campos_personalizados', App\Models\User::class)
                            <td class="p-0 pl-2 pr-2 text-right text-nowrap">
                                <a class="" href="{{ route('custom_fields.delete_request', ['custom_field' => $item->id]) }}">
                                    <i class="icon-trash"></i>
                                    {{ __('lang.button_delete') }}
                                </a>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="tab-pane fade" id="tab-DocumentCustomField" role="tabpanel" aria-labelledby="DocumentCustomField">
        <table class="table table-sm nowrap table-hover table-striped">
            <thead class="table-active text-center">
                <th class="p-0 pl-2 pr-2">Nome</th>
                <th class="p-0 pl-2 pr-2">Formato</th>
                <th class="p-0 pl-2 pr-2">Obrigatorio</th>
                <th class="p-0 pl-2 pr-2">Para todos os projectos</th>
                <th class="p-0 pl-2 pr-2">usado por</th>
                @can('excluir_campos_personalizados', App\Models\User::class)
                    <th class="p-0 pl-2 pr-2 text-nowrap"></th>
                @endcan
            </thead>

            <tbody>
                @foreach ($data['DocumentCustomField'] as $item)
                    <tr>
                        <td class="p-0 pl-2 pr-2">
                            <a href="{{ route('custom_fields.edit', ['custom_field' => $item->id ]) }}">{{  $item->name   }}</a>
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            {{ __('lang.label_field_format_'.$item->field_format) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if ($item->is_required)
                                <i class="icon-checkmark-circle text-success"></i>
                            @endif
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if ($item->is_for_all)
                                <i class="icon-checkmark-circle text-success"></i>
                            @endif
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if (!$item->is_for_all)
                                {{ __('lang.label_x_projects.zero') }}
                            @endif
                        </td>
                        @can('excluir_campos_personalizados', App\Models\User::class)
                            <td class="p-0 pl-2 pr-2 text-right text-nowrap">
                                <a class="" href="{{ route('custom_fields.delete_request', ['custom_field' => $item->id]) }}">
                                    <i class="icon-trash"></i>
                                    {{ __('lang.button_delete') }}
                                </a>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="tab-pane fade" id="tab-UserCustomField" role="tabpanel" aria-labelledby="UserCustomField">
        <table class="table table-sm nowrap table-hover table-striped">
            <thead class="table-active text-center">
                <th class="p-0 pl-2 pr-2">Nome</th>
                <th class="p-0 pl-2 pr-2">Formato</th>
                <th class="p-0 pl-2 pr-2">Obrigatorio</th>
                @can('excluir_campos_personalizados', App\Models\User::class)
                    <th class="p-0 pl-2 pr-2 text-nowrap"></th>
                @endcan
            </thead>

            <tbody>
                @foreach ($data['UserCustomField'] as $item)
                    <tr>
                        <td class="p-0 pl-2 pr-2">
                            <a href="{{ route('custom_fields.edit', ['custom_field' => $item->id ]) }}">{{  $item->name   }}</a>
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            {{ __('lang.label_field_format_'.$item->field_format) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if ($item->is_required)
                                <i class="icon-checkmark-circle text-success"></i>
                            @endif
                        </td>
                        @can('excluir_campos_personalizados', App\Models\User::class)
                            <td class="p-0 pl-2 pr-2 text-right text-nowrap">
                                <a class="" href="{{ route('custom_fields.delete_request', ['custom_field' => $item->id]) }}">
                                    <i class="icon-trash"></i>
                                    {{ __('lang.button_delete') }}
                                </a>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="tab-pane fade" id="tab-GroupCustomField" role="tabpanel" aria-labelledby="GroupCustomField">
        <table class="table table-sm nowrap table-hover table-striped">
            <thead class="table-active text-center">
                <th class="p-0 pl-2 pr-2">Nome</th>
                <th class="p-0 pl-2 pr-2">Formato</th>
                <th class="p-0 pl-2 pr-2">Obrigatorio</th>
                <th class="p-0 pl-2 pr-2">Para todos os projectos</th>
                <th class="p-0 pl-2 pr-2">usado por</th>
                @can('excluir_campos_personalizados', App\Models\User::class)
                    <th class="p-0 pl-2 pr-2 text-nowrap"></th>
                @endcan
            </thead>

            <tbody>
                @foreach ($data['GroupCustomField'] as $item)
                    <tr>
                        <td class="p-0 pl-2 pr-2">
                            <a href="{{ route('custom_fields.edit', ['custom_field' => $item->id ]) }}">{{  $item->name   }}</a>
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            {{ __('lang.label_field_format_'.$item->field_format) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if ($item->is_required)
                                <i class="icon-checkmark-circle text-success"></i>
                            @endif
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if ($item->is_for_all)
                                <i class="icon-checkmark-circle text-success"></i>
                            @endif
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if (!$item->is_for_all)
                                {{ __('lang.label_x_projects.zero') }}
                            @endif
                        </td>
                        @can('excluir_campos_personalizados', App\Models\User::class)
                            <td class="p-0 pl-2 pr-2 text-right text-nowrap">
                                <a class="" href="{{ route('custom_fields.delete_request', ['custom_field' => $item->id]) }}">
                                    <i class="icon-trash"></i>
                                    {{ __('lang.button_delete') }}
                                </a>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="tab-pane fade" id="tab-PartnerCustomField" role="tabpanel" aria-labelledby="PartnerCustomField">
        <table class="table table-sm nowrap table-hover table-striped">
            <thead class="table-active text-center">
                <th class="p-0 pl-2 pr-2">Nome</th>
                <th class="p-0 pl-2 pr-2">Formato</th>
                <th class="p-0 pl-2 pr-2">Obrigatorio</th>
                <th class="p-0 pl-2 pr-2">usado por</th>
                @can('excluir_campos_personalizados', App\Models\User::class)
                    <th class="p-0 pl-2 pr-2 text-nowrap"></th>
                @endcan
            </thead>

            <tbody>
                @foreach ($data['PartnerCustomField'] as $item)
                    <tr>
                        <td class="p-0 pl-2 pr-2">
                            <a href="{{ route('custom_fields.edit', ['custom_field' => $item->id ]) }}">{{  $item->name   }}</a>
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            {{ __('lang.label_field_format_'.$item->field_format) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if ($item->is_required)
                                <i class="icon-checkmark-circle text-success"></i>
                            @endif
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if (!$item->is_for_all)
                                {{ "nenhum parceiro" }}
                            @endif
                        </td>
                        @can('excluir_campos_personalizados', App\Models\User::class)
                            <td class="p-0 pl-2 pr-2 text-right text-nowrap">
                                <a class="" href="{{ route('custom_fields.delete_request', ['custom_field' => $item->id]) }}">
                                    <i class="icon-trash"></i>
                                    {{ __('lang.button_delete') }}
                                </a>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="tab-pane fade" id="tab-TimeEntryActivityCustomField" role="tabpanel" aria-labelledby="TimeEntryActivityCustomField">
        <table class="table table-sm nowrap table-hover table-striped">
            <thead class="table-active text-center">
                <th class="p-0 pl-2 pr-2">Nome</th>
                <th class="p-0 pl-2 pr-2">Formato</th>
                <th class="p-0 pl-2 pr-2">Obrigatorio</th>
                <th class="p-0 pl-2 pr-2">Para todos os projectos</th>
                <th class="p-0 pl-2 pr-2">usado por</th>
                @can('excluir_campos_personalizados', App\Models\User::class)
                    <th class="p-0 pl-2 pr-2 text-nowrap"></th>
                @endcan
            </thead>

            <tbody>
                @foreach ($data['TimeEntryActivistomField'] as $item)
                    <tr>
                        <td class="p-0 pl-2 pr-2">
                            <a href="{{ route('custom_fields.edit', ['custom_field' => $item->id ]) }}">{{  $item->name   }}</a>
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            {{ __('lang.label_field_format_'.$item->field_format) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if ($item->is_required)
                                <i class="icon-checkmark-circle text-success"></i>
                            @endif
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if ($item->is_for_all)
                                <i class="icon-checkmark-circle text-success"></i>
                            @endif
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if (!$item->is_for_all)
                                {{ __('lang.label_x_projects.zero') }}
                            @endif
                        </td>
                        @can('excluir_campos_personalizados', App\Models\User::class)
                            <td class="p-0 pl-2 pr-2 text-right text-nowrap">
                                <a class="" href="{{ route('custom_fields.delete_request', ['custom_field' => $item->id]) }}">
                                    <i class="icon-trash"></i>
                                    {{ __('lang.button_delete') }}
                                </a>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="tab-pane fade" id="tab-DocumentCategoryCustomField" role="tabpanel" aria-labelledby="DocumentCategoryCustomField">
        <table class="table table-sm nowrap table-hover table-striped">
            <thead class="table-active text-center">
                <th class="p-0 pl-2 pr-2">Nome</th>
                <th class="p-0 pl-2 pr-2">Formato</th>
                <th class="p-0 pl-2 pr-2">Obrigatorio</th>
                <th class="p-0 pl-2 pr-2">Para todos os projectos</th>
                <th class="p-0 pl-2 pr-2">usado por</th>
                @can('excluir_campos_personalizados', App\Models\User::class)
                    <th class="p-0 pl-2 pr-2 text-nowrap"></th>
                @endcan
            </thead>

            <tbody>
                @foreach ($data['DocumentCategoryCustomField'] as $item)
                    <tr>
                        <td class="p-0 pl-2 pr-2">
                            <a href="{{ route('custom_fields.edit', ['custom_field' => $item->id ]) }}">{{  $item->name   }}</a>
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            {{ __('lang.label_field_format_'.$item->field_format) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if ($item->is_required)
                                <i class="icon-checkmark-circle text-success"></i>
                            @endif
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if ($item->is_for_all)
                                <i class="icon-checkmark-circle text-success"></i>
                            @endif
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center">
                            @if (!$item->is_for_all)
                                {{ __('lang.label_x_projects.zero') }}
                            @endif
                        </td>
                        @can('excluir_campos_personalizados', App\Models\User::class)
                            <td class="p-0 pl-2 pr-2 text-right text-nowrap">
                                <a class="" href="{{ route('custom_fields.delete_request', ['custom_field' => $item->id]) }}">
                                    <i class="icon-trash"></i>
                                    {{ __('lang.button_delete') }}
                                </a>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
