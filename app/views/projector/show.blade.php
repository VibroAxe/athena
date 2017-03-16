@extends('layouts.projector')
@section('content')

	{{ Purifier::clean(Markdown::string($slide->content), 'markdown') }}

@endsection				
