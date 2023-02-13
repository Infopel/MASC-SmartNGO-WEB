@extends('layouts.main', ['title' => __('lang.label_program_plural').' - '.$program->name])
@section('content')
    <div class="row p-2">
        <div class="col-md-12">
            <div class="row m-0">
                <div class="card-block pl-3 pt-3 pr-3 pr-3 pb-2 rounded my-shadow">
                    <div class="d-md-flex">
                        <div class="flex-grow-1">
                            <h5 class="link-option">
                                PDE: <a href="">{{ $program->parent['name'] }}</a>
                            </h5>
                        </div>
                        <div class="d-block text-black-50">
                            <small>Ultima Actualização:
                                {{ \Carbon\Carbon::parse($program->updated_on)->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h5>
                                <a href="{{ route('programs.index') }}">{{ 'Programas' }}</a> » {{ $program->name }}
                                <a href="{{ route('programs.edit' , ['program' => $program->identifier]) }}" title="Editar">
                                    <i class="icon-pencil5"> </i>
                                </a>
                            </h5>
                        </div>
                        <div class="">
                            <h5 class="fw-700">
                                <span class="text-black-50">{{ __('lang.project_module_budget') }}:</span>
                                <span class="text-success">
                                    <a href="#" class="text-success">{{ number_format((0), 2) }} MZN</a>
                                </span>
                            </h5>
                        </div>
                    </div>
                    {{-- sessions alerts --}}
                    @include('errors.any')
                    {{-- sessions alerts --}}
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mt-2 border-right">
                    <div class="card-block rounded p-3">
                        <div class="d-flex border-bottom">
                            <div class="flex-grow-1">
                                Visão Geral do Programa
                            </div>
                            <div class="text-black-50">
                                <small>Ultima Actualização:
                                    {{ \Carbon\Carbon::parse($program->updated_on)->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                        <div class="">
                            {!! $program->description !!}

                            <ul class="ul" style="font-size: 92%">
                            @foreach ($program->customFieldValues()->where('customized_type', 'Program')->get() as $key => $custom_value)

                                @if ($custom_value->custom_field['field_format'] == 'list')
                                    <li class="">
                                        <span class="fw-500">{{ $key }}:</span>
                                        <ul>
                                            @foreach ($custom_value['values'] as $item)
                                                @if ($item['is_selected'])
                                                    <li class="">{{ $item['value'] }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li class=""><span class="fw-500">{{ $custom_value->custom_field->name }}:</span> {{ $custom_value->value }}</li>
                                @endif
                            @endforeach
                        </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mt-2">
                    <div class="card-block rounded p-3">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h5>
                                    {{ __('lang.label_project_plural') }}
                                </h5>
                            </div>
                            @can('cadastrar_projectos', \App\Models\Projects::class)
                                <div class="">
                                    <a href="{{ route('projects.new', ['parent' => $program->identifier]) }}" class="text-success mr-2">
                                        <i class="icon-plus-circle2" style="font-size: 90%"></i>
                                        <span>{{ __('lang.label_project_new') }}</span>
                                    </a>
                                </div>
                            @endcan
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-sm border">
                                <thead class="table-active text-nowrap">
                                    <th>{{ __('lang.label_project') }}</th>
                                    <th class="text-center">{{ __('lang.label_member_plural') }}</th>
                                    <th class="text-center">{{ __('lang.label_issue_plural') }}</th>
                                    <th class="text-right">{{ __('lang.field_created_on') }}</th>
                                </thead>
                                <tbody>
                                    @foreach ($program->childs as $project)
                                        <tr>
                                            <td class="p-0 pl-2 pr-2">
                                                <a href="{{ route('projects.overview', ['project_identifier' => $project->identifier]) }}">
                                                    {{ $project->name }}
                                                </a>
                                            </td>
                                            <td class="p-0 pl-2 pr-2 text-center">
                                                {{ $project->members->count() }}
                                            </td>
                                            <td class="p-0 pl-2 pr-2 text-center">
                                                {{ $project->issues->count() }}
                                            </td>
                                            <td class="p-0 pl-2 pr-2 text-right text-nowrap">
                                                {{ \Carbon\Carbon::parse($project->created_on)->diffForHumans() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
