@extends('layouts.default')
@section('content')
	@include('layouts.default.title')
	@include('layouts.default.alerts')

	{{ Form::model(null, ['route' => ['users.linkservice', $service], 'class' => 'form-horizontal']) }}
		@if ($service == 'mpuk')
			@include('userlink.partials.mpuk')
		@elseif ($service == 'origin')
			@include('userlink.partials.origin')
		@elseif ($service == 'ticketfactory')
			@include('userlink.partials.ticketfactory')
		@else
			<h1>Invalid Link Service Target</h1>
		@endif
	{{ Form::close() }}

@endsection
