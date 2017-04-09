@extends('layouts.default')
@section('content')
	@include('layouts.default.title')
	@include('layouts.default.alerts')

	{{ Form::model($feedback, ['route' => 'feedback.store', 'class' => 'form-horizontal']) }}
		@include('feedback.partials.form')
	{{ Form::close() }}

@endsection
