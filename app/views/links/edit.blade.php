@extends('layouts.default')
@section('content')
	@include('layouts.default.title')
	@include('layouts.default.alerts')

	{{ Form::model($link, ['route' => ['links.update', $link->id], 'method' => 'PUT', 'class' => 'form-horizontal') }}
		@include('links.partials.form')
	{{ Form::close() }}

@endsection
