@use('Timespan');
@extends('layouts.default')
@section('content')
	@include('layouts.default.title')
	@include('layouts.default.alerts')

	@if (count($uploads))
		<table class="table">
			<thead>
				<tr>
					<th>Title</th>
					@if ( Authority::can('manage', 'uploads') )
          				<th>Last Updated</th>
		  				<th class="text-center">{{ Icon::cog() }}</th>
					@endif
				</tr>
			</thead>
			<tbody>
			@foreach( $uploads as $upload )
				<tr>
					<td><a href="{{ url().$upload->url}}">{{$upload->title}}</a></td>
          			@if ( Authority::can('manage', 'uploads') )
					  <td>{{ $upload->updated_at->diffForHumans() }}</td>
						<td class="text-center">
							@include('buttons.edit', ['resource' => 'uploads', 'item' => $upload, 'size' => 'extraSmall'])
							@include('buttons.destroy', ['resource' => 'uploads', 'item' => $upload, 'size' => 'extraSmall'])
						</td>
					@endif
				</tr>
			@endforeach
			</tbody>
    </table>
          
	@else
		<p>No uploads found!</p>
	@endif
	@include('buttons.create', ['resource' => 'uploads'])
@endsection
