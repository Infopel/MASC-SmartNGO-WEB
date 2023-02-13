<div class="row m-0 n-header border-bottom my-shadow mt-3">
    <div class="col-md-12 top-header pl-3 pt-1 pr-0">
        <div class="d-flex">
            <div class="lc-header mr-auto">

                <a class="navbar-brand" ><img src="{{ asset("images/nav_masc.png") }}"   style="width:100px; height: 50px;" >

                @if (request()->is('/'))
                    <small>{{ $settings['app_title'] }}</small>
                    <h4 class="">{{ $settings['app_client_name'] ?? 'MASC'}}</h4>
                @elseif (request()->is('projects'))
                    <small>{{ $settings['app_title'] ?? 'MASC'}}</small>
                    <h4 class="">{{ __('lang.label_project_plural') }}</h4>
                @elseif(request()->is('projects/*'))
                    <small>{{ $settings['app_title'] ?? 'MASC' }}</small>
                    <h4 class="">{{ $_project['name'] ?? 'MASC' }}</h4>
                @elseif(request()->is('issues/*'))
                    <small>{{ $settings['app_title'] }}</small>
                    <h4 class="">{{ $_project['name'] ?? 'MASC' }}</h4>
                @elseif(request()->is('documents/*'))
                    <small>{{ $settings['app_title'] }}</small>
                    <h4 class="">{{ $_project['name'] ?? 'MASC' }}</h4>
                @elseif(request()->is('minha/pagina'))
                    <small>{{ $settings['app_title'] ?? 'MASC' }}</small>
                    <h4 class="">{{ __('lang.label_my_page') }}</h4>
                @elseif(request()->is('relatorios'))
                    <small>{{ $settings['app_title'] ?? 'MASC' }}</small>
                    <h4 class="">{{ __('lang.label_reports') }}</h4>
                @elseif(request()->is('admin'))
                    <small>{{ $settings['app_title'] ?? 'MASC' }}</small>
                    <h4 class="">{{ __('lang.label_administration') }}</h4>
                @elseif(request()->is('ajuda'))
                    <small>{{ $settings['app_title'] ?? 'MASC' }}</small>
                    <h4 class="">{{ __('lang.label_help') }}</h4>
                @else
                    <p></p>
                    <h4 class="pb-1">{{ $settings['app_title'] ?? null }}</h4>
                @endif
                </a>
            </div>
            <div class="rc-header d-flex ml-auto">

                @livewire('master-search-component')

                <div class="">
                    <div class="p-2 cursor-pointer" id="dropdownNotidications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-bell2 pt-2 mt-1" style="font-size:24px"></i>
                    </div>
                    <div class="dropdown-menu border-0 my-shadow mt-10" aria-labelledby="dropdownNotidications">
                        <h6 class="dropdown-header">Notificações (0)</h6>
                        <a class="dropdown-item" href="#">
                            <i class="icon-bell3"></i>
                            <span>{{ __('Novas') }} (0)</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="icon-eye2"></i>
                            <span>{{ __('Lidas') }} (0)</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="icon-eye-blocked2"></i>
                            <span>{{ __('Não Lidas') }} (0)</span>
                        </a>
                    </div>
                </div>
                <div class="">
                    <div class="d-flex pr-2 pl-2 pt-2 cursor-pointer" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="m-1 mr-2 user-label">
                            {{ ucfirst(Auth::user()->firstname[0].Auth::user()->lastname[0]) }}
                        </div>
                        <div class="user-lables text-nowrap">
                            <div><b>{{ Auth::user()->firstname }}</b></div>
                            <div>
                                @if (Auth::user()->admin)
                                    Administrador
                                @else
                                    MASC - {{ date('Y') }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-menu border-0 mt-2 my-shadow border-bottom" aria-labelledby="dropdownMenuButton">
                        <h6 class="dropdown-header">{{ Auth::user()->full_name }}</h6>
                        <a class="dropdown-item" href="{{ route('app.userPage', ['user' => Auth::user()->id]) }}">
                            <i class="icon-user-plus"></i>
                            <span>{{ __('lang.label_my_page') }}</span>
                        </a>
                        <a class="dropdown-item" href="{{ route('app.minha-conta') }}">
                            <i class="icon-cog5"></i>
                            <span>{{ __('lang.label_my_account') }}</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="icon-switch2"></i>
                            <span>{{ __('lang.label_logout') }}</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
