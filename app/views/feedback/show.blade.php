@extends('layouts.default')
@section('content')
  <div class="container">
    <div class="row bgspacer"></div>
    <div class="row">
      <div class="col-md-2">
      </div>
      <div class="col-md-8">
  {{ Purifier::clean(Markdown::string($feedback->feedback), 'markdown') }}
      </div>
      <div class="col-md-2">
      </div>
    </div>
  </div>

@endsection				
