@extends('layouts.default')
@section('content')
	@include('layouts.default.title')
	@include('layouts.default.alerts')

	@if (count($slides))
		<table class="table">
			<thead>
				<tr>
					<th>Title</th>
					@if ( Authority::can('manage', 'projector') )
          <th class="text-center">Timeout</th>
          <th class="text-center">Order</th>
          <th class="text-center">Active</th>
          <th>Last Updated</th>
		  		<th class="text-center">{{ Icon::cog() }}</th>
					@endif
				</tr>
			</thead>
			<tbody>
			@foreach( $slides as $slide )
				<tr>
					<td>{{ link_to_route('projector.show', $slide->title, $slide->id) }}</td>
          @if ( Authority::can('manage', 'projector') )
            <td class="text-center">{{ $slide->timespan }}</td>
            <td class="text-center">{{ $slide->position }}</td>
            <td class="text-center">
              <a href="{{ url()."/projector/".$slide->id."/toggle" }}">
							  @if ( $slide->published ) 
                  @if (($slide->startdate == null || $slide->startdate <= date('Y-m-d H:i:s')) && ($slide->enddate == null || $slide->enddate >= date('Y-m-d H:i:s')))
                    <span style="color: #5CB85C;">{{ Icon::ok() }}</span>
                  @elseif ( $slide->startdate != null && $slide->startdate >= date('Y-m-d H:i:s'))
                    <span style="color: orange;">{{ Icon::ok() }}</span>
                  @else
                    <span style="color: red;">{{ Icon::ok() }}</span>
                  @endif
                @else
                  <span style="color:red;">{{ Icon::remove() }}</span>
                @endif
                </a>
						</td>
					  <td>{{ $slide->updated_at->diffForHumans() }}</td>
						<td class="text-center">
							@include('buttons.edit', ['resource' => 'projector', 'item' => $slide, 'size' => 'extraSmall'])
							@include('buttons.destroy', ['resource' => 'projector', 'item' => $slide, 'size' => 'extraSmall'])
						</td>
					@endif
				</tr>
			@endforeach
			</tbody>
    </table>
    <table class="table">
      <thead>
        <tr>
          <th>Key:</th>
          <th class="text-right"><span style="color:red;">{{ Icon::remove() }}</span> Inactive</th>
          <th class="text-right"><span style="color:#5CB85C;">{{ Icon::ok() }}</span> Active</th>
          <th class="text-right"><span style="color:orange;">{{ Icon::ok() }}</span> Active (Awaiting Start)</th>
          <th class="text-right"><span style="color:red;">{{ Icon::ok() }}</span> Active (Finished)</th>
        </tr>
      </thead>
    </table>
          
	@else
		<p>No pages found!</p>
	@endif
	@include('buttons.create', ['resource' => 'projector'])
@endsection
