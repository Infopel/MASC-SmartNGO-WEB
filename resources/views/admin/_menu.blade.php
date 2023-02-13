<div class="row h-100" >
    <div class="card-block w-100 p-3 {{ request()->is('admin') ? '' : 'border-left aside-panel' }}">
        <div class="">
            <h5>{{ __('lang.label_administration') }}</h5>
        </div>
        <div class="admin-menu">
            <ul>
                @can('gerir_projectos', App\Models\User::class)
                    <li class="fw-500 {{ Route::is('admin.projects') ? 'selected' : '' }}">
                        <a href="{{ route('admin.projects') }}" class="p-1">
                            <i class="icon-stack2 text-danger"></i>
                            <span>{{ __('lang.label_project') }}</span>
                        </a>
                    </li>
                @endcan

                {{-- Ver Users --}}
                @can('ver_usuarios', App\Models\User::class)
                    <li class="fw-500 {{ Route::is('users.*') ? 'selected' : '' }}">
                        <a href="{{ route('users.index') }}" class="p-1">
                            <i class="icon-users text-success-400"></i>
                            <span>{{ __('lang.label_user_plural') }}</span>
                        </a>
                    </li>
                @endcan

                @can('gerir_grupos', App\Models\User::class)
                    <li class="fw-500 {{ Route::is('groups.*') ? 'selected' : '' }}">
                        <a href="{{ route('groups.index') }}" class="p-1">
                            <i class="icon-users4 text-success-700"></i>
                            <span>{{ __('lang.label_group_plural') }}</span>
                        </a>
                    </li>
                @endcan

                <li class="fw-500 {{ Route::is('partners.*') ? 'selected' : '' }}">
                    <a href="{{ route('partners.index') }}" class="p-1">
                        <i class="icon-users4 text-success-700"></i>
                        <span>{{ __('lang.label_partner_plural') }}</span>
                    </a>
                </li>

                @can('ver_permisoes', App\Models\Roles::class)
                    <li class="fw-500 {{ Route::is('roles.*') ? 'selected' : '' }}">
                        <a href="{{ route('roles.index') }}" class="p-1">
                            <i class="icon-database-check text-violet-700"></i>
                            <span>{{ __('lang.label_role_and_permissions') }}</span>
                        </a>
                    </li>
                @endcan

                {{-- <li class="fw-500 {{ Route::is('global_roles.*') ? 'selected' : '' }}">
                    <a href="{{ route('global_roles.index') }}" class="p-1">
                        <i class="icon-database-check text-danger-700"></i>
                        <span>{{ __('Permissões Globais') }}</span>
                    </a>
                </li> --}}
                @can('gerir_tipos_tarefas', App\Models\User::class)
                    <li class="fw-500 {{ Route::is('tracker.*') ? 'selected' : '' }}">
                        <a href="{{ route('tracker.index') }}" class="p-1">
                            <i class="icon-task"></i>
                            <span>{{ __('lang.label_tracker_plural') }}</span>
                        </a>
                    </li>
                @endcan

                @can('gerir_estados_tarefas', App\Models\User::class)
                    <li class="fw-500 {{ Route::is('issue_statuses.*') ? 'selected' : '' }}">
                        <a href="{{ route('issue_statuses.index') }}" class="p-1">
                            <i class="icon-stack4 text-danger-700"></i>
                            <span>{{ __('lang.label_issue_status_plural') }}</span>
                        </a>
                    </li>
                @endcan

                <li class="fw-500 {{ Route::is('workflows.*') ? 'selected' : '' }}">
                    <a href="{{ route('workflows.edit') }}" class="p-1">
                        <i class="icon-direction text-violet-700"></i>
                        <span>{{ __('lang.label_workflow') }}</span>
                    </a>
                </li>

                <li class="fw-500 {{ Route::is('approvement_flows.*') ? 'selected' : '' }}">
                    <a href="{{ route('approvement_flows.index') }}" class="p-1">
                        <i class="icon-filter3 text-danger-700"></i>
                        <span>{{ __('Fluxo de Aprovação') }}</span>
                    </a>
                </li>

                <li class="fw-500 {{ Route::is('plan_aprovemmnt.plan_Aprovemnt') ? 'selected' : '' }}">
                    <a href="{{ route('plan_aprovemmnt.plan_Aprovemnt') }}" class="p-1">
                        <i class="icon-filter3 text-danger-700"></i>
                        <span>{{ __('Aprovação de Plano de Actividades') }}</span>
                    </a>
                </li>

                @can('gerir_campos_personalizados', App\Models\User::class)
                    <li class="fw-500 {{ Route::is('custom_fields.*') ? 'selected' : '' }}">
                        <a href="{{ route('custom_fields.index') }}" class="p-1">
                            <i class="icon-file-text"></i>
                            <span>{{ __('lang.label_custom_field_plural') }}</span>
                        </a>
                    </li>
                @endcan

                @can('ver_tipos_categorias', App\Models\User::class)
                    <li class="fw-500 {{ Route::is('enumerations.*') ? 'selected' : '' }}">
                        <a href="{{ route('enumerations.index') }}" class="p-1">
                            <i class="icon-list-unordered text-warning"></i>
                            <span>{{ __('lang.label_enumerations') }}</span>
                        </a>
                    </li>
                @endcan

                @can('config_orcamento_projectos', App\Models\Budgets::class)
                    <li class="fw-500 {{ Route::is('budget.*') ? 'selected' : '' }}">
                        <a href="{{ route('budget.config.index') }}" class="p-1">
                            <i class="icon-coins"></i>
                            <span>{{ __('lang.label_budget') }}</span>
                        </a>
                    </li>
                @endcan

                <li class="fw-500 {{ Route::is('settings.index') ? 'selected' : '' }}">
                    <a href="{{ route('settings.index') }}" class="p-1">
                        <i class="icon-cogs"></i>
                        <span>{{ __('lang.label_settings') }}</span>
                    </a>
                </li>

                <li class="fw-500 {{ Route::is('bugCenter.solicitacaoFundos') ? 'selected' : '' }}">
                    <a href="{{ route('bugCenter.solicitacaoFundos') }}" class="p-1 text-danger">
                        <i class="icon-bug2"></i>
                        <span>{{ "Bug Ceneter" }}</span>
                    </a>
                </li>

                <li class="fw-500 {{ Route::is('dashbord_admin.usosistema') ? 'selected' : '' }}">
                    <a href="{{ route('dashbord_admin.usosistema') }}" class="p-1 text-danger">
                        <i class="icon-bug2"></i>
                        <span>{{ "Dashbord Admin" }}</span>
                    </a>
                </li>

                <li class="fw-500 {{ Route::is('admin.info') ? 'selected' : '' }}">
                    <a href="{{ route('admin.info') }}" class="p-1">
                        <i class="icon-info22"></i>
                        <span>{{ __('lang.label_information_plural') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
{{-- Menu /Configurations --}}
