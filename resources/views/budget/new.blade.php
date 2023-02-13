@extends('layouts.main')
@section('content')
    @include('errors.any')
    @livewire('budget-form', $project ? : null, $isEdit ?: false, $errors, $budget ? : null)
@endsection
