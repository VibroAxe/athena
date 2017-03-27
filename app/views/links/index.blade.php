@use('Timespan');
@extends('layouts.default')
@section('content')
	@include('layouts.default.title')
	@include('layouts.default.alerts')

	@if (count($links))
		<table class="table">
			<thead>
				<tr>
					<th>Title</th>
					<th>Short Title</th>
					@if ( Authority::can('manage', 'links') )
          				<th class="text-center">Active</th>
          				<th>Last Updated</th>
		  				<th class="text-center">{{ Icon::cog() }}</th>
					@endif
				</tr>
			</thead>
			<tbody>
			@foreach( $links as $link )
				<tr>
					<td>{{ link_to_route('links.show', $link->title, $link->id) }}</td>
					<td>{{ $link->shorttitle }}</td>
          @if ( Authority::can('manage', 'link') )
            <td class="text-center">
              <a href="{{ url()."/links/".$link->id."/toggle" }}">
							  @if ( $link->published ) 
                    <span style="color: #5CB85C;">{{ Icon::ok() }}</span>
                				@else
                  <span style="color:red;">{{ Icon::remove() }}</span>
				                @endif
                </a>
            </td>
					  <td>{{ $link->updated_at->diffForHumans() }}</td>
						<td class="text-center">
							@include('buttons.edit', ['resource' => 'links', 'item' => $link, 'size' => 'extraSmall'])
							@include('buttons.destroy', ['resource' => 'links', 'item' => $link, 'size' => 'extraSmall'])
						</td>
					@endif
				</tr>
			@endforeach
			</tbody>
    </table>
          
	@else
		<p>No links found!</p>
	@endif
	@include('buttons.create', ['resource' => 'links'])
@endsection
