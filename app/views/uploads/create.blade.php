@extends('layouts.default')
@section('content')
	@include('layouts.default.title')
	@include('layouts.default.alerts')

	{{ Form::model($upload, ['route' => 'uploads.store', 'class' => 'form-horizontal', 'files' => true]) }}
		@include('uploads.partials.form')
	{{ Form::close() }}

@endsection
