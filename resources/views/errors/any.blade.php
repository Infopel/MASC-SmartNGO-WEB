{{-- session rows --}}
<div class="w-100">
    @if ($errors->any())
        <div class="alert alert-danger p-2">
            <ul class="m-0 list-unstyled pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
{{-- /session rows --}}
@if (session('success'))
    <div class="ml-0 pt-1 pb-1 pl-3 pr-3 alert alert-success">
        <i class="icon-checkmark"></i>
        {!! session('success') !!}
    </div>
@elseif(session('warning'))
    <div class="ml-0 p-2 alert alert-warning">
        <i class="icon-warning2"></i>
        {!! session('warning') !!}
    </div>
@elseif(session('error'))
    <div class="ml-0 p-2 alert alert-danger">
        <i class="icon-warning2"></i>
        {!! session('error') !!}
    </div>
@endif
