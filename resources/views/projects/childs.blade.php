@foreach ($childs as $child)
    <div class="childs _hover">
        <div class="proj-title">
            <a href="{{ route('projects.overview', ['project_identifier' => $child['identifier']]) }}" class="{{ $child['status'] == 5 ? 'text-back-50' : null }}">
                <span>{{ $child['name'] }}</span> <span class="text-danger">{{ $child['status']  == 5 ? '- Fechado' : null }}</span>
                <i></i>
            </a>
        </div>
        <div class="proj-desc border-bottom mb-2">
            {!! $child['description'] !!}
        </div>

        @if (isset($child['child']))
            @include('projects.childs', ['childs' => $child['child']])
        @endif
    </div>
@endforeach
