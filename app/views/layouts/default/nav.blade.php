<?php
$navbar = [];

if ( Config::get('lanager/nav.showPages',true) ) {
  //using $pageMenus
  foreach($pageMenus as $title => $menu) {
    if (count($menu) == 1) {
      $navbar[] = [
        'title' => $title,
        'link' => $menu[0]['link'],
        ];
    }
    else {
      $navbar[] = [
        $title,
        $menu,
      ];
    }
  }
}

if ( Config::get('lanager/nav.showShouts',false) ) {
  $navbar[] = [
    'title' => 'Shoutbox',
    'link' => URL::route('shouts.index'),
    ];
}
if ( Config::get('lanager/nav.showEvents',true) ) {
  $navbar[] = [ 
    'title' => 'Events',
    'link' => URL::route('events.index'),
  ];
}
if ( Config::get('lanager/nav.showUsers',true) ) {
  $navbar[] = [
    'title' => 'Users',
    'link' => URL::route('users.index'),
  ];
}
if ( Config::get('lanager/nav.showGames',true) ) {
  $navbar[] = [
    'title' => 'Games',
    'link' => URL::route('application-usage.index'),
  ];
}


if ( Config::get('lanager/nav.showExtras',true) ) {
  $extras = [];
	if ( Config::get('lanager/nav.showProjector',true) ) {
		$extras[] = [
			'title' => 'Athena Portal',
			'link' => URL::route('projector.index'),
			'linkAttributes' => ['target' => '_new'],
		];
	}
  if ( Config::get('lanager/nav.showExtrasDashboard',true) ) {
    $extras[] = [
      'title' => 'Live Dashboard',
      'link' => URL::route('dashboard.index'),
      ];
  }
  if ( Config::get('lanager/nav.showExtrasAchievements',true) ) {
    $extras[] = [
      'title' => 'Achievements',
      'link' => URL::route('achievements.index'),
      ];
  }
  if ( Config::get('lanager/nav.showExtrasUserAchievements',true) ) {
			$extras[] = [
				'title' => 'User Achievements',
				'link' => URL::route('user-achievements.index'),
      ];
  }
  if ( Config::get('lanager/nav.showExtrasLans',true) ) {
			$extras[] = [
				'title' => 'LANs',
				'link' => URL::route('lans.index'),
      ];
  }
  if ( Config::get('lanager/nav.showExtrasRoles',true) ) {
			$extras[] = [
				'title' => 'Roles',
				'link' => URL::route('roles.index'),
      ];
  }
  if ( Config::get('lanager/nav.showExtrasUserRoles',true) ) {
			$extras[] = [
				'title' => 'User Roles',
				'link' => URL::route('user-roles.index'),
      ];
  }
  if ( Config::get('lanager/nav.showExtrasEventTypes',true) ) {
			$extras[] = [
				'title' => 'Event Types',
				'link' => URL::route('event-types.index'),
      ];
  }
    

  $navbar[] = [
    'Extras',
    $extras,
    ];
}
if ( Config::get('lanager/nav.showLinks',true) ) {
  $navbar[] = [
    'Links',
    $links,
    ];
}

/*
$navbar[] = 
[
	[
		'title' => 'Events',
		'link' => URL::route('events.index'),
	],
	[
		'title' => 'Users',
		'link' => URL::route('users.index'),
	],
	[
		'title' => 'Games',
		'link' => URL::route('application-usage.index'),
	],
	[
		'Info',
		$info,
	],
	[
		'Extras',
		[
			[
				'title' => 'Live Dashboard',
				'link' => URL::route('dashboard.index'),
			],
			[
				'title' => 'Achievements',
				'link' => URL::route('achievements.index'),
			],
			[
				'title' => 'User Achievements',
				'link' => URL::route('user-achievements.index'),
			],
			[
				'title' => 'LANs',
				'link' => URL::route('lans.index'),
			],
			[
				'title' => 'Roles',
				'link' => URL::route('roles.index'),
			],
			[
				'title' => 'User Roles',
				'link' => URL::route('user-roles.index'),
			],
			[
				'title' => 'Event Types',
				'link' => URL::route('event-types.index'),
			],
		],
	],
	[
		'Links',
		$links,
	],
];
 */
echo Navbar::create(Navbar::NAVBAR_TOP)->withBrand('<img src="' . asset('img/logo.png') .'" width="140" height="35" alt="LANager Logo">')
			->withContent(
				Navigation::links($navbar)
			)
			->withContent(View::make('layouts/default/auth'));
