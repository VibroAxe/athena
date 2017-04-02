@if ( count($applications) )
	<table class="table states-current-usage">
	@foreach($applications as $application)
		<tr>
			<td class="application">
				<a href="{{ $application['url'] }}" title="View {{ $application['name'] }} in the Steam Store">
					<img src="{{ $application['logo_small'] }}" alt="{{ $application['name'] }}">
				</a>
			</td>
			<td class="user-count">
				{{ count($application['users']) }} In Game
			</td>
			<td class="user-list">
				<?php $userCount = 0; ?>
				@foreach( $application['users'] as $user )
					@for ($i=0;$i<200;$i++)
					<?php $userCount++; ?>
					@if ($userCount == 41)
						<a href="#app{{$application['id']}}" data-toggle="collapse" class="btn btn-default">More</a>
						<span id="app{{$application['id']}}" class="collapse">
					@endif
						<a href="{{ URL::route('users.show', $user['id']) }}">
							<img src="{{ $user['avatar_small']}}">
						</a>
					@endfor
				@endforeach
				@if ($userCount >= 41)
					</span>
				@endif
			</td>
		</tr>
	@endforeach
	</table>

@else
	<p>No game usage to show!</p>
@endif

<script>
$('td.user-list span').on('hidden.bs.collapse', function () {
	var $this = $(this);
	$(this).parent().find('a.btn').text('More')
})
$('td.user-list span').on('show.bs.collapse', function () {
	var $this = $(this);
	$(this).parent().find('a.btn').text('Less')
})
	</script>
