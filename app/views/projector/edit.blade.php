@extends('layouts.default')
@section('content')
	@include('layouts.default.title')
	@include('layouts.default.alerts')

	{{ Form::model($slide, ['route' => ['projector.update', $slide->id], 'method' => 'PUT', 'class' => 'form-horizontal', 'files' => true]) }}
		@include('projector.partials.form')
	{{ Form::close() }}

@endsection
