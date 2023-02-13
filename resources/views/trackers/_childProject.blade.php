<ul class="projects root">
    @foreach ($projects as $project)
        <li class="root mb-0">
            <div class="root mb-0">
                <label class="root mb-0" for="project_id_{{ $project->id }}">
                    @isset($tracker->projects_trackers)
                        @if(in_array($project->id, array_column($tracker->projects_trackers->toArray(), 'project_id')))
                            <input type="checkbox" name="project_ids[]" id="project_id_{{ $project->id }}" Checked='checked' value="{{ $project->id }}">
                            {{ $project->name }}
                        @else
                            <input type="checkbox" name="project_ids[]" id="project_id_{{ $project->id }}" value="{{ $project->id }}">
                            {{ $project->name }}
                        @endif
                    @else
                        <input type="checkbox" name="project_ids[]" id="project_id_{{ $project->id }}" value="{{ $project->id }}">
                            {{ $project->name }}
                    @endisset
                </label>
            </div>
            @isset($project->child)
                @include('trackers._childProject', ['projects' => $project->child])
            @endisset
        </li>
    @endforeach
</ul>
