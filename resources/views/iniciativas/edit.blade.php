@extends('layouts.main')
@section('content')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="pull-left">
				<h3> Edit iniciativa </h3>
			</div>
			<div class="pull-right">
				<a class="btn btn-success" href="{{ route('iniciativas.index') }}"> Back to iniciativa List </a>
			</div>
		</div>
	</div>

	@if($errors->any())
		<div class="alert alert-danger">
			<strong>Oopps! </strong> Something went wrong.
			<ul>
				@foreach($errors->all() as $error)
					<li> {{ $error }} </li>
				@endforeach
			</ul>
		</div>
	@endif

	<form action="{{ route('iniciativas.update', $iniciativa->id) }}" method="POST">
		@csrf
		@method("PUT")
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<strong>nome:</strong>
					<input type="text" name="name" value="{{ $iniciativa->nome }}" class="form-control" placeholder="Name">
				</div>
			</div>

			<div class="col-lg-6 form-group">
				<select name="" value id="">
					@foreach ($iniciativa as $item)
						<option value="">{{ $iniciativa->bairro }}</option>
					@endforeach
				</select>
			</div>

			<div class="col-lg-12">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</div>
	</form>
@endsection