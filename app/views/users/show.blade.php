@extends('layouts.default')
@section('content')

	@include('users.partials.private-profile-warning')
	
	<div class="profile-header">
		<div class="profile-avatar">
			@include('users.partials.avatar', ['user' => $user, 'size' => 'large'] )
		</div>
		<div>
			<h1>
				{{{ $user->username }}}
				@include('roles.partials.badges', ['roles' => $user->roles])
			</h1>
				@include('users.partials.status', ['state' => $user->state] )
		</div>

	</div>
	<div class="profile-actions">
		@include('users.partials.actions', ['user' => $user] )
	</div>
	<div class="profile-nav">
		<ul class="nav nav-tabs">
			<li role="presentation" class="<?php if (Input::get('tab',"accounts") == 'accounts') echo 'active'; ?>">
				<a href="{{ route('users.show', ['user' => $user->id, 'tab' => 'accounts'] ) }}">
					Accounts
				</a>
			</li>
			<li role="presentation" class="<?php if (Input::get('tab') == 'system-specs') echo 'active'; ?>">
				<a href="{{ route('users.show', ['user' => $user->id, 'tab' => 'system-specs'] ) }}">
					System Specs
				</a>
			</li>
			<li role="presentation" class="<?php if (Input::get('tab') == 'achievements') echo 'active'; ?>">
				<a href="{{ route('users.show', ['user' => $user->id, 'tab' => 'achievements'] ) }}">
					Achievements {{ View::make('badge', ['collection' => $user->userAchievements] ) }}
				</a>
			</li>
			<li role="presentation" class="<?php if (Input::get('tab') == 'shouts') echo 'active'; ?>">
				<a href="{{ route('users.show', ['user' => $user->id, 'tab' => 'shouts'] ) }}">
					Shouts {{ View::make('badge', ['collection' => $user->shouts] ) }}
				</a>
			</li>
			@if ( Auth::check() AND $user->id == Auth::user()->id )
				@if (Config::Get('lanager/nav.showApi',false))
				<li role="presentation" class="<?php if (Input::get('tab') == 'api') echo 'active'; ?>">
					<a href="{{ route('users.show', ['user' => $user->id, 'tab' => 'api'] ) }}">
						API
					</a>
				</li>
				@endif
			@endif
		</ul>
	</div>
	<div class="profile-content">
		@include('layouts.default.alerts')

		@if ( Input::get('tab','accounts') == 'accounts')
			<?php
				$services = Config::get("lanager/oauth.services",['Discord' => 1,'Battle.Net' => 1]);
			?>
			<div class="panel-group">
				@forelse( $user->OAuths()->get() as $OAuth)
				<?php $services[$OAuth->service] = 0; ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							{{ $OAuth->service }}
						</h4>
					</div>
					<div class="panel-body">
						@if ($OAuth->avatar != null)
							<img src="{{ $OAuth->avatar }}" class="img img-rounded"/>&nbsp;
							@endif
							<h4 style="display: inline">
								{{ $OAuth->username }}
							</h4>
					</div>
				</div>
			@empty
				<p>No accounts linked to Athena</p>
			@endforelse
			</div>
			@if (Auth::check() AND ($user->id == Auth::user()->id OR $user->id == "me"))
				<ul class="nav nav-pills">
				@foreach($services as $service => $enabled) 
					@if ($enabled)	
						<li class="active">
							<a href="/users/link/{{ $service }}">Link Athena to {{ $service }}</a>
						</li>
					@endif
				@endforeach
				</ul>
			@endif
			
		@elseif ( Input::get('tab') == 'system-specs' )
			Coming soon
		@elseif ( Input::get('tab') == 'achievements' )
			@include('user-achievements.partials.ribbon', ['userAchievements' => $user->userAchievements()->orderBy('lan_id','desc')->orderBy('created_at','desc')->get()])
			@include('user-achievements.partials.list-singleuser', ['userAchievements' => $user->userAchievements()->orderBy('lan_id','desc')->orderBy('created_at','desc')->get()] )

		@elseif ( Input::get('tab') == 'shouts' )

			@include('shouts.partials.list', ['shouts' => $user->shouts()->orderBy('created_at','desc')->get()] )

		@elseif ( Input::get('tab') == 'api' AND Auth::check() AND $user->id == Auth::user()->id )

			@include('users.partials.api', ['user' => $user])

		@endif

	</div>

@endsection
