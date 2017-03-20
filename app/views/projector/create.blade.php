@extends('layouts.default')
@section('content')
	@include('layouts.default.title')
	@include('layouts.default.alerts')

	{{ Form::model($slide, ['route' => 'projector.store', 'class' => 'form-horizontal']) }}
		@include('projector.partials.form')
	{{ Form::close() }}

@endsection
