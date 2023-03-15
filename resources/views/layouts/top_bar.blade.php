<div class="top_bar fixed-top">
    <div class="top_bar-content">
        <ul>
            <li>
                <a class="top-bar-link" href="{{ route('app.index') }}">
                    <i class="icon-home2"></i>
                    <span>{{ __('lang.label_home') }}</span>
                </a>
            </li>
            <li>
                <a class="top-bar-link" href="{{ route('app.userPage', ['user' => auth()->user()->id]) }}">
                    <i class="icon-user text-success"></i>
                    <span>{{ __('lang.label_my_page') }}</span>
                </a>
            </li>
            <li>
                <a class="top-bar-link" href="{{ route('app.projectos') }}">
                    <i class="icon-stack2 text-danger"></i>
                    <span>{{ __('lang.label_project_plural') }}</span>
                </a>
            </li>
            <li>
                <a class="top-bar-link" href="{{ route('app.timesheets') }}">
                    <i class="icon-stack2 text-danger"></i>
                    <span>{{ __('lang.label_timesheet') }}</span>
                </a>
            </li>
            <li>
                <a class="top-bar-link" href="{{ route('iniciativas') }}">
                    <i class="icon-brain text-danger"></i>
                    <span>{{ __('lang.label_initiative_plural') }}</span>
                </a>
            </li>
            <li>
                <a class="top-bar-link" href="{{ route('programs.index') }}">
                    <i class="icon-books"></i>
                    <span>{{ __('lang.label_program_plural') }}</span>
                </a>
            </li>
            <li>
                <a class="top-bar-link" href="{{ route('reports.orcamento_pde') }}">
                    <i class="icon-stats-bars2 text-primary"></i>
                    <span>{{ __('lang.label_report_plural') }}</span>
                </a>
            </li>
            @can('gerir_painel_admin', App\Models\User::class)
                <li>
                    <a class="top-bar-link" href="{{ route('admin.index') }}">
                        <i class="icon-cogs"></i>
                        <span>{{ __('lang.label_administration') }}</span>
                    </a>
                </li>
            @endcan
            <li>
                <a class="top-bar-link" href="{{ route('app.help') }}">
                    <i class="icon-help text-info"></i>
                    <span>{{ __('lang.label_help') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
