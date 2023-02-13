
<div class="nav-bar my-shadow bg-white">
    <nav class="navbar p-0 navbar-content navbar-light bg-white " style="white-space: nowrap;">

        @if (!Route::is('admin.*') && !Route::is('users.*') && !request()->is('/') && !Route::is('app.userPage') && !Route::is('dashboard.*') && !Route::is('groups.*') && !Route::is('roles.*') && !Route::is('tracker.*') && !Route::is('issue_statuses.*') && !Route::is('workflows.*') && !Route::is('custom_fields.*') && !Route::is('enumerations.*') && !Route::is('settings.*') && !Route::is('app.help'))
            @isset($_project)
                {{-- <a class="nav-item pl-2 pr-2" href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">+</a> --}}
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Nova Tarefa</a>
                    <a class="dropdown-item" href="#">Nova Categoria</a>
                    <a class="dropdown-item" href="#">Tempo de trabalho</a>
                    <a class="dropdown-item" href="#">Novo Documento</a>
                </div>
                <div class="" style="white-space: nowrap; overflow-x: auto; padding-bottom: 3px; overflow-y: hidden;">
                    {{-- <a class="nav-item {{ Route::is('projects.overview') ? 'active' : '' }}" href="{{ route('projects.overview', ['project_identifier' => $_project['identifier']]) }}">{{ __('lang.label_overview') }}</a> --}}

                    <a class="nav-item {{ Route::is('projects.activity') ? 'active' : '' }}" href="{{ route('projects.activity', ['project_identifier' => $_project['identifier']]) }}">{{ __('lang.label_activity') }}</a>
                    {{--!!dd($_project);!!--}}
                    @isset($_project['type'])
                        @if ($_project['type'] == 'Program')
                            <a class="nav-item {{ Route::is('projects.issues.*') ? 'active' : '' }} {{ Route::is('issues.*') ? 'active' : '' }}"
                            href="{{ route('projects.issues.tracking', ['project_identifier' => $_project['identifier']]) }}">
                            {{ __('lang.project_module_issue_tracking') }}
                            </a>
                        @endif
                    @endisset

                    @php
                        $route = request()->route()->getPrefix();
                        $route = \str_replace('/', '', $route);
                        // echo $module["module"];
                    @endphp

                    @if (in_array('issue_tracking', array_column($_modules, 'module')))
                        @can('view_issues', [\App\Models\Projects::class, $_project['project']])
                            <a class="nav-item {{ Route::is('projects.issues.*') ? 'active' : '' }} {{ Route::is('issues.*') ? 'active' : '' }} {{ Route::is(''.$route.'.issue_tracking') ? 'active' : '' }}"
                                href="{{ route('projects.issues.tracking', ['project_identifier' => $_project['identifier']]) }}">
                                {{ __('lang.project_module_issue_tracking') }}
                            </a>
                        @endcan
                    @endif
                    @if (in_array('time_tracking', array_column($_modules, 'module')))
                        @can('view_time_entries', [\App\Models\Projects::class, $_project['project']])
                            <a class="nav-item {{ Route::is('projects.time_tracking') ? 'active' : '' }} {{ Route::is('time_entries.*') ? 'active' : '' }} {{ Route::is(''.$route.'.time_tracking') ? 'active' : '' }}"
                                href="{{ route('projects.time_tracking', ['project_identifier' => $_project['identifier']]) }}">
                                {{ __('lang.project_module_time_tracking') }}
                            </a>
                        @endcan
                    @endif
                    @if (in_array('gantt', array_column($_modules, 'module')))
                        @can('view_gantt', [\App\Models\Gantt::class, $_project['project']])
                            <a class="nav-item {{ Route::is('projects.gantt') ? 'active' : '' }} {{ Route::is(''.$route.'.gantt') ? 'active' : '' }}"
                                href="{{ route('projects.gantt', ['project_identifier' => $_project['identifier']]) }}">
                                {{ __('lang.project_module_gantt') }}
                            </a>
                        @endcan
                    @endif
                    @if (in_array('calendar', array_column($_modules, 'module')))
                        @can('view_calendar', [\App\Models\Projects::class, $_project['project']])
                            <a class="nav-item {{ Route::is('projects.calendar') ? 'active' : '' }} {{ Route::is(''.$route.'.calendar') ? 'active' : '' }}"
                                href="{{ route('projects.calendar', ['project_identifier' => $_project['identifier']]) }}">
                                {{ __('lang.project_module_calendar') }}
                            </a>
                        @endcan
                    @endif
                    @if (in_array('news', array_column($_modules, 'module')))
                        @can('view_news', [\App\Models\News::class, $_project['project']])
                            <a class="nav-item {{ Route::is('projects.news') ? 'active' : '' }} {{ Route::is(''.$route.'.news') ? 'active' : '' }}"
                                href="{{ route('projects.news', ['project_identifier' => $_project['identifier']]) }}">
                                {{ __('lang.label_news') }}
                            </a>
                        @endcan
                    @endif
                    @if (in_array('documents', array_column($_modules, 'module')))
                        @can('view_documents', [\App\Models\Documents::class, $_project['project']])
                            <a class="nav-item {{ Route::is('projects.documents') ? 'active' : '' }} {{ Route::is(''.$route.'.documents') ? 'active' : '' }} {{ Route::is('documents.*') ? 'active' : '' }}"
                                href="{{ route('projects.documents', ['project_identifier' => $_project['identifier']]) }}">
                                {{ __('lang.project_module_documents') }}
                            </a>
                        @endcan
                    @endif
                    @if (in_array('wiki', array_column($_modules, 'module')))
                        @can('view_wiki_pages', [\App\Models\Wikis::class, $_project['project']])
                            <a class="nav-item {{ Route::is('projects.wiki.*') ? 'active' : '' }} {{ Route::is(''.$route.'.wiki') ? 'active' : '' }}"
                                href="{{ route('projects.wiki', ['project_identifier' => $_project['identifier']]) }}">
                                {{ __('lang.project_module_wiki') }}
                            </a>
                        @endcan
                    @endif

                    {{-- @if (in_array('budget', array_column($_modules, 'module')))
                        @can('budget', [\App\Models\Projects::class, $_project['project']])
                            <a class="nav-item {{ Route::is('projects.budget.*') ? 'active' : '' }} {{ Route::is(''.$route.'.budget') ? 'active' : '' }}"
                                href="{{ route('projects.budget', ['project_identifier' => $_project['identifier']]) }}">
                                {{ __('lang.project_module_budget') }}
                            </a>
                        @endcan
                    @endif --}}

                    @isset($_project['type'])
                        @if ($_project['type'] == 'Project')
                            <a class="nav-item {{ Route::is('orcamento.projecto.index') ? 'active' : '' }} {{ Route::is(''.$route.'.budget') ? 'active' : '' }}"
                                href="{{ route('orcamento.projecto.index', ['project_identifier' => $_project['identifier']]) }}">
                                {{ __('Orçamento do Projecto') }}
                            </a>
                        @endif

                        {{-- @if ($_project['type'] == 'Project')
                            <a class="nav-item {{ Route::is('orcamento.projecto.solicitacao-fundos') ? 'active' : '' }} {{ Route::is('orcamento.projecto.solicitacao-fundos.*') ? 'active' : '' }}"
                                href="{{ route('orcamento.projecto.solicitacao-fundos', ['project_identifier' => $_project['identifier']]) }}">
                                {{ __('Solicitação de Fundos') }}
                            </a>
                        @endif --}}

                        <a class="nav-item {{ Route::is('orcamento.projecto.solicitacao_fundos') ? 'active' : '' }} {{ Route::is('orcamento.projecto.solicitacao_fundos.*') ? 'active' : '' }}"
                            href="{{ route('orcamento.projecto.solicitacao_fundos', ['project_identifier' => $_project['identifier']]) }}">
                            {{ __('Solicitação de Fundos') }}
                        </a>
                    @endisset

                    @isset(($_project['name']), ($_project['type']))
                        @if ($_project['status'] == 5)
                        @else
                            @if ($_project['type'] == 'PDE')
                                @can('editar_plano_estrategico', [\App\Models\Projects::class, $_project['project']])
                                    <a class="nav-item {{ Route::is('projects.settings') ? 'active' : '' }}" href="{{ route('projects.settings', ['project_identifier' => $_project['identifier']]) }}">{{ __('lang.label_settings') }}</a>
                                @endcan
                            @else
                                @can('editar_projectos', [ \App\Models\Projects::class, $_project['project']])
                                    <a class="nav-item {{ Route::is('projects.settings') ? 'active' : '' }}" href="{{ route('projects.settings', ['project_identifier' => $_project['identifier']]) }}">{{ __('lang.label_settings') }}</a>
                                @endcan
                            @endif
                        @endif
                    @endisset
                </div>
            @else
               <div class="" style="white-space: nowrap; overflow-x: auto; padding-bottom: 3px; overflow-y: hidden;">

                        <a class="nav-item {{ Route::is('app.projectos') ? 'active' : '' }}" href="{{ route('app.projectos') }}">
                            {{ __('lang.label_project_plural') }}
                        </a>
                        @isset($program)
                            <a class="nav-item {{ Route::is('projects.issues.*') ? 'active' : '' }} {{ Route::is('issues.*') ? 'active' : '' }}"
                            href="{{ route('projects.issues.tracking', ['project_identifier' => $program['identifier']]) }}">
                            {{ __('lang.project_module_issue_tracking') }}
                            </a>
                        @endisset

                       {{-- <a class="nav-item {{ Route::is('issues.*') ? 'active' : '' }}" href="{{ route('issues.index') }}">
                            {{ __('lang.label_issue_tracking') }}
                        </a>--}}
                        <a class="nav-item {{ Route::is('time_entries.*') ? 'active' : '' }}" href="{{ route('time_entries.index') }}">
                            {{ __('lang.label_spent_time') }}
                        </a>
                        <a class="nav-item {{ Route::is('gantt.*') ? 'active' : '' }}" href="{{ route('gantt.index') }}">
                            {{ __('lang.project_module_gantt') }}
                        </a>
                        <a class="nav-item {{ Route::is('calendar.*') ? 'active' : '' }}" href="{{ route('calendar.index') }}">
                            {{ __('lang.project_module_calendar') }}
                        </a>
                        <a class="nav-item {{ Route::is('news.*') ? 'active' : '' }}" href="{{ route('news.index') }}">
                            {{ __('lang.label_news') }}
                        </a>

                </div>


            @endisset


        @endif
        @if(request()->is('/') || request()->is('dashboard/*'))
            <a class="nav-item {{ Route::is('app.index') ? 'active' : '' }}" href="{{ route('app.index') }}">{{ __('lang.label_dashboard') }}</a>

            <a class="nav-item {{ Route::is('dashboard.user_approvement_flow') ? 'active' : '' }}" href="{{ route('activityPlanApprovement.index') }}">
                {{ __('Aprovação P. Atividades') }}
            </a>

        @endif
    </nav>
</div>
