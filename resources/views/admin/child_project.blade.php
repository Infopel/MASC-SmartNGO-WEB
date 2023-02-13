
@foreach ($childs as $project)
    <tr class="child_level-{{ $child_level }} {{ $project->status == 1 ? '' : "text-black-50" }}">
        <td class="name">
            @if ($project->status == 9)
                <i class="icon-arrow-right5"></i>
                <a>{{ $project->name }}</a>
            @else
                <a href="{{ route('projects.settings', ['project_identifier' => $project->identifier]) }}" class="{{ $project->status == 1 ? '' : "text-black-50" }}">
                    <i class="icon-arrow-right5"></i>
                    {{ $project->name }}
                </a>
            @endif
        </td>
        <td class="text-center">
            @if ($project->is_public)
                <i class="icon-checkmark-circle position-left  {{ $project->status == 1 ? 'text-success' : "text-black-50" }}"></i>
            @endif
        </td>
        <td>{{ date('d-m-Y', strtotime($project->created_on)) }}</td>
        <td class="text-right">

            @can('arquivar_projeto', App\Models\User::class)
                <a href="{{ route('projects.request_action', ['project_identifier' => $project->identifier, 'action' => $project->status == 9 ? 'unarchive' : 'archive']) }}" class="{{ $project->status == 1 ? '' : "text-black-50" }}">
                    <i class="icon-pin"></i>
                    <span>{{ $project->status == 9 ? __('lang.button_unarchive') : __('lang.button_archive') }}</span>
                </a>
            @endcan
            {{-- <a href="" class="{{ $project->status == 1 ? 'text-slate-800' : "text-black-50" }}">
                <i class="icon-copy3"></i>
                <span>{{ __('lang.button_copy') }}</span>
            </a> --}}

            @if ($project->type == 'Project')
                @can('excluir_projectos', [App\Models\Projects::class, $project])
                    <a href="{{ route('projects.request_action', ['project_identifier' => $project->identifier, 'action' => 'delete']) }}" class="{{ $project->status == 1 ? 'text-danger-400' : "text-black-50" }}">
                        <i class="icon-trash"></i>
                        <span>{{ __('lang.button_delete') }}</span>
                    </a>
                @endcan
            @else
                @can('excluir_linhas_estrategicas', [App\Models\Projects::class, $project])
                    <a href="{{ route('projects.request_action', ['project_identifier' => $project->identifier, 'action' => 'delete']) }}" class="{{ $project->status == 1 ? 'text-danger-400' : "text-black-50" }}">
                        <i class="icon-trash"></i>
                        <span>{{ __('lang.button_delete') }}</span>
                    </a>
                @endcan
            @endif

        </td>
    </tr>

    @isset($project->child)
        @php
            $level = 1+ $child_level
        @endphp
        @include('admin.child_project', ['childs' => $project->child, 'child_level' => $level])
    @endisset


@endforeach

