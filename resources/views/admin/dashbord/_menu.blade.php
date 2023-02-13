<div class="row h-100 shadow-sm" >
    <div class="card-block w-100 p-3 {{ request()->is('admin') ? '' : 'border-left aside-panel' }}">
        <div class="">
            <h5>{{ "Dashbord Admin" }}</h5>
        </div>
        <div class="admin-menu">
            <ul>
                <li class="fw-500 {{ Route::is('dashbord_admin.usosistema') ? 'selected' : '' }}">
                    <a href="{{ route('dashbord_admin.usosistema') }}" class="p-1">
                        <i class="icon-bug2"></i>
                        <span>{{ "Nivel de Uso do Sistema" }}</span>
                    </a>
                </li>

                <li class="fw-500 {{ Route::is('dashbord_admin.assiduidade') ? 'selected' : '' }}">
                    <a href="{{ route('dashbord_admin.assiduidade') }}" class="p-1">
                        <i class="icon-info22"></i>
                        <span>{{"Assiduidade no Sitema"}}</span>
                    </a>
                </li>

                <li class="fw-500 {{ Route::is('dashbord_admin.actividades_reportar') ? 'selected' : '' }}">
                    <a href="{{ route('dashbord_admin.actividades_reportar') }}" class="p-1">
                        <i class="icon-bug2"></i>
                        <span>{{ "Actividades Por Reportar" }}</span>
                    </a>
                </li>

                <li class="fw-500 {{ Route::is('dashbord_admin.dados_em_falta') ? 'selected' : '' }}">
                    <a href="{{ route('dashbord_admin.dados_em_falta') }}" class="p-1">
                        <i class="icon-info22"></i>
                        <span>{{"Projectos com Dados em Falta"}}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
{{-- Menu /Configurations --}}
