@extends('layouts.main')
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-12 col-md-12 p-0 admin-container">

            {{-- <div class="d-flex">
                <div class="flex-grow-1">
                    <h4>{{ $user->firstname.' '.$user->lastname }}</h4>
                </div>
                <div class="d-flex">
                    <a href="#" class="link-option ml-2">
                        <i class="icon-pencil5"></i>
                        <span>{{ __('lang.button_edit') }}</span>
                    </a>

                </div>
            </div> --}}

            <div class="row h-100 m-0">
                <div class="user-perfil" >
                    <div class="border min-shadow p-3 bg-white" style="">
                        <div class="thumb thumb-rounded thumb-slide border bg-light align-items-center d-flex justify-content-center" style="height:160px;">
                            <h1 class="fw-600 text-back-50">{{ ucfirst($user->firstname[0].'.'.$user->lastname[0]) }}</h1>
                        </div>
                        <div class="caption text-center mt-4 mb-3">
                            <h6 class="text-semibold no-margin">{{ $user->full_name }}
                                <small class="display-block">{{ $user->email_address->address }}</small>
                            </h6>
                        </div>
                        {{-- <hr class="mt-3 m-2"> --}}
                        {{-- <div class="col btn bg-light border-bottom">
                            <a href="#" class=" link-option">
                                <i class="icon-pencil5"></i>
                                <span>{{ __('lang.button_edit') }}</span>
                            </a>
                        </div> --}}
                    </div>

                    {{-- Details painel --}}
                    <div class="border min-shadow p-2 bg-white mt-3 mb-3" style="">
                        <div class="m-2">
                            <div class="fw-500 small text-black-50" style="font-size:92%">
                                Nome de utilizador:
                            </div>
                            <div class="link-option" style="font-size:100%">
                                {{ $user->login}}
                            </div>
                        </div>

                        @foreach ($user->user_details as $item)
                            <div class="m-2 user_details underline_from_left">
                                <div class="fw-500 small text-black-50" style="font-size:92%">
                                    {{ $item['name'] }}:
                                </div>
                                <div class="fw-500">
                                    {{ $item['values'] ?? null}}
                                </div>
                            </div>
                        @endforeach


                        <div class="d-flex m-2">
                            <div class="flex-grow-1">
                                Registrado em:
                            </div>
                            <div class="fw-500">
                                {{ $user->created_on }}
                            </div>
                        </div>
                        <div class="d-flex m-2">
                            <div class="flex-grow-1">
                                Última conexão:
                            </div>
                            <div class="fw-500">
                                {{ $user->last_login_on }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="bg-white border min-shadow p-2">
                        <h5>
                            <a href="">{{ __('lang.label_project_plural') }}</a>
                        </h5>

                        <div class="table-responsive  bg-white">
                            <table class="table table-sm table-striped table-hover border">
                                <thead class="table-active">
                                    <th>Project</th>
                                    <th>Role</th>
                                    <th>Atribuido a</th>
                                    <th>_</th>
                                </thead>

                                <tbody>
                                    @foreach ($user->member_of as $project)
                                        @isset($project->project)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('projects.overview', ['project_identifier' => $project['project']['identifier']]) }}">
                                                        {{ $project->project->name }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @isset($project->member_roles)
                                                        @foreach ($project['member_roles']['roles'] as $role)
                                                            {{ $role['name'] }} ||
                                                        @endforeach
                                                     @endisset
                                                </td>
                                                <td class="nowrap">{{ $project->_created_on }}</td>
                                                <td class="nowrap">{{ $project->_time }}</td>
                                            </tr>
                                        @endisset
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="col">
                    <h5>
                        <a href="">{{ __('lang.label_activity') }}</a>
                    </h5>
                </div>

            </div>
        </div>

    </div>
@endsection
