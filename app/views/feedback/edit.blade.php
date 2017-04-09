@extends('layouts.default')
@section('content')
	@include('layouts.default.title')
	@include('layouts.default.alerts')

	{{ Form::model($feedback, ['route' => ['feedback.update', $feedback->id], 'method' => 'PUT', 'class' => 'form-horizontal']) }}
		@include('feedback.partials.form')
	{{ Form::close() }}

@endsection
