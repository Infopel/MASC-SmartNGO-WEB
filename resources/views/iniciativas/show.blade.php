@extends('layouts.main')
@section('content')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="pull-left">
				<h3> Iniciativas </h3>
			</div>
			<div class="pull-right">
				<a class="btn btn-success" href="{{ route('iniciativas.index') }}"> Volatar para aba Iniciativas </a>
			</div>
		</div>
	</div>

	<div class="row">
			<div class="col-lg-12">
				<div class="form-group">
					<strong>Nome:</strong>
					{{ $iniciativa->nome }}
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<strong>Nome:</strong>
					{{ $iniciativa->nome }}
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<strong>Nome:</strong>
					{{ $iniciativa->nome }}
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<strong>Nome:</strong>
					{{ $iniciativa->nome }}
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<strong>Nome:</strong>
					{{ $iniciativa->nome }}
				</div>
			</div>
	</div>
@endsection