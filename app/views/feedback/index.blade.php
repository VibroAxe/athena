@extends('layouts.default')
@section('content')
	@include('layouts.default.title')
	@include('layouts.default.alerts')

	@if ( Authority::can('manage', 'feedback') )
		@if (count($feedback))
		<table class="table">
			<thead>
				<tr>
					<th>Id</th>
					<th>User</th>
          			<th>Prioriy</th>
          			<th>Feedback</th>
          			<th>Last Updated</th>
		  			<th class="text-center">{{ Icon::cog() }}</th>
				</tr>
			</thead>
			<tbody>
			@foreach( $feedback as $fb )
				<tr>
					<td>{{ link_to_route('feedback.show', $fb->id, $fb->id) }}</td>
					@if ($fb->user_id != null)
					<td>{{ $fb->user->username }}</td>
					@else
						<td></td>
					@endif
					<td>{{ $fb->priorityAsText() }}</td>
					<td>
					@if (strlen($fb->feedback)>=40)
						{{ Purifier::clean(Markdown::string(substr($fb->feedback,0,40)), 'feedbackpreview') }}...
						@else
						{{ Purifier::clean(Markdown::string($fb->feedback), 'feedbackpreview') }}
					@endif
					</td>
					  <td>{{ $fb->updated_at->diffForHumans() }}</td>
						<td class="text-center">
							@include('buttons.edit', ['resource' => 'feedback', 'item' => $fb, 'size' => 'extraSmall'])
							@include('buttons.destroy', ['resource' => 'feedback', 'item' => $fb, 'size' => 'extraSmall'])
						</td>
				</tr>
			@endforeach
			</tbody>
    </table>
          
	@else
		<p>No feedback found!</p>
	@endif
	@include('buttons.create', ['resource' => 'feedback'])
@endif
@endsection
