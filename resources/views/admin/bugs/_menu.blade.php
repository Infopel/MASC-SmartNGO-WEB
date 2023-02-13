<div class="row h-100 shadow-sm" >
    <div class="card-block w-100 p-3 {{ request()->is('admin') ? '' : 'border-left aside-panel' }}">
        <div class="">
            <h5>{{ "Bug Center Management" }}</h5>
        </div>
        <div class="admin-menu">
            <ul>
                <li class="fw-500 {{ Route::is('bugCenter.solicitacaoFundos') ? 'selected' : '' }}">
                    <a href="{{ route('bugCenter.solicitacaoFundos') }}" class="p-1">
                        <i class="icon-bug2"></i>
                        <span>{{ "Solicitação de Fundos" }}</span>
                    </a>
                </li>

                <li class="fw-500 {{ Route::is('admin.info') ? 'selected' : '' }}">
                    <a href="#" class="p-1">
                        <i class="icon-info22"></i>
                        <span>{{ __('lang.label_information_plural') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
{{-- Menu /Configurations --}}
