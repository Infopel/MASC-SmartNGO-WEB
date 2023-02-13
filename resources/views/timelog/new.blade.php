@extends('layouts.main')
@section('content')
   @include('errors.any')
   @livewire('time-spent', \collect([
      'issue' => $issue,
      'time_entrie' => $time_entrie ?? [],
      'recourceType' => $resourceType ?? null,
      'isEdit' => $isEdit ?? false,
   ]))
@endsection
