@if (count($userAchievements))
	<div class="achievement-ribbon">
		@foreach( $userAchievements as $userAchievement )
			@include('user-achievements.partials.icon', [ 'userAchievement' => $userAchievement ])
		@endforeach
	</div>
@endif
