@extends('layouts.projector')
@section('content')
  <div class="container">
    <div class="row bgspacer"></div>
    <div class="row">
      <div class="col-md-1">
      </div>
      <div class="col-md-10">
  {{ Markdown::string($slide->content) }}
      </div>
      <div class="col-md-1">
      </div>
    </div>
  </div>

@endsection				
