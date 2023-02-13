<div class="row h-100 shadow-sm" >
    <div class="card-block w-100 p-3 {{ request()->is('admin') ? '' : 'border-left aside-panel' }}">
        <div class="">
            <h5>{{ "Aprovacao do Plano" }}</h5>
        </div>
        <div class="admin-menu">
            <ul>
                <li class="fw-500 {{ Route::is('plan_aprovemmnt.plan_Aprovemnt') ? 'selected' : '' }}">
                    <a href="{{ route('plan_aprovemmnt.plan_Aprovemnt') }}" class="p-1">
                        <i class="icon-bug2"></i>
                        <span>{{ "Projectos" }}</span>
                    </a>
                </li>

                <li class="fw-500 {{ Route::is('plan_aprovemmnt.plan_Aprovemnt') ? 'selected' : '' }}">
                    <a href="{{ route('plan_aprovemmnt.plan_Aprovemnt') }}" class="p-1">
                        <i class="icon-info22"></i>
                        <span>{{"Aprovacao Finaceira"}}</span>
                    </a>
                </li>

                <li class="fw-500 {{ Route::is('plan_aprovemmnt.plan_Aprovemnt') ? 'selected' : '' }}">
                    <a href="{{ route('plan_aprovemmnt.plan_Aprovemnt') }}" class="p-1">
                        <i class="icon-bug2"></i>
                        <span>{{ "Aprovacao Executiva" }}</span>
                    </a>
                </li>


            </ul>
        </div>
    </div>
</div>
{{-- Menu /Configurations --}}
