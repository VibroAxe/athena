<?php

//URL::forceSchema('https');

Route::group(
[
	'namespace' => 'Zeropingheroes\Lanager\Http\Gui',
	'before' => 'permission',
],
function()
{
	/*
	|--------------------------------------------------------------------------
	| Users
	|--------------------------------------------------------------------------
	*/
	Route::post('users/link/{service}', ['as' => 'users.linkservice','uses' => 'UserLinkController@linkservice']);
	Route::get('users/link/{service}', ['as' => 'users.linkservice','uses' => 'UserLinkController@linkservice']);
	Route::resource('users', 'UsersController', ['only' => ['index', 'show', 'destroy']]);

	Route::resource('users.systemspecs', 'UserSystemSpecsController', ['only' => ['index', 'store', 'destroy']]);

	Route::resource('user-roles', 'UserRolesController', ['only' => ['index', 'create', 'store', 'destroy']]);
	Route::resource('user-achievements', 'UserAchievementsController', ['only' => ['index', 'create', 'edit', 'store', 'update', 'destroy']]);

	/*
	|--------------------------------------------------------------------------
	| Sessions
	|--------------------------------------------------------------------------
	*/
	Route::resource('sessions', 'SessionsController');
	Route::get('login', ['as' => 'sessions.create', 'uses' => 'SessionsController@create']);
	Route::get('logout', ['as' => 'sessions.destroy', 'uses' => 'SessionsController@destroy']);

	/*
	|--------------------------------------------------------------------------
	| Pages
	|--------------------------------------------------------------------------
	 */
	Route::resource('pages', 'PagesController');
	Route::get('pages/{id}/{prettyname}', [ 'as' => 'pages.show', 'uses' => 'PagesController@show']);

	/*
	|--------------------------------------------------------------------------
	| Shouts
	|--------------------------------------------------------------------------
	*/
	Route::resource('shouts', 'ShoutsController', ['only' => ['index', 'store', 'update', 'destroy']]);

	/*
	|--------------------------------------------------------------------------
	| Application Usage
	|--------------------------------------------------------------------------
	*/
	Route::resource('application-usage', 'ApplicationUsageController', ['only' => ['index']]);

	/*
	|--------------------------------------------------------------------------
	| Events
	|--------------------------------------------------------------------------
	*/
	Route::resource('events', 'EventsController');
	Route::resource('events.signups', 'EventSignupsController', ['only' => ['index', 'store', 'destroy']]);
	Route::resource('event-types', 'EventTypesController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);

	/*
	|--------------------------------------------------------------------------
	| Achievements
	|--------------------------------------------------------------------------
	*/
	Route::resource('achievements', 'AchievementsController');

	/*
	|--------------------------------------------------------------------------
	| LANs
	|--------------------------------------------------------------------------
	*/
	Route::resource('lans', 'LansController');

	/*
	|--------------------------------------------------------------------------
	| Roles
	|--------------------------------------------------------------------------
	*/
	Route::resource('roles', 'RolesController');

	/*
	|--------------------------------------------------------------------------
	| Logs
	|--------------------------------------------------------------------------
	*/
	Route::resource('logs', 'LogsController', ['only' => ['index', 'show']]);

	/*
	|--------------------------------------------------------------------------
	| Dashboard
	|--------------------------------------------------------------------------
	*/
	Route::get('dashboard', ['as' => 'dashboard.index', 'uses' => 'DashboardController@index']);
	/*
	|--------------------------------------------------------------------------
	| Projector
	|--------------------------------------------------------------------------
	*/
	Route::get('projector/manage', ['as' => 'projector.manage','uses' => 'ProjectorController@manage']);
  	Route::get('projector/{id}/toggle', ['as' => 'projector.toggle','uses' => 'ProjectorController@toggle']);
  	Route::resource('projector', 'ProjectorController');
	/*
	|--------------------------------------------------------------------------
	| Uploads
	|--------------------------------------------------------------------------
	*/
  	Route::resource('uploads', 'UploadsController', [ 'only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']] );
	/*
	|--------------------------------------------------------------------------
	| External
	|--------------------------------------------------------------------------
	*/
	Route::get('external', ['as' => 'external.show','uses' => 'ExternalController@show'] );
	/*
	|--------------------------------------------------------------------------
	| Links
	|--------------------------------------------------------------------------
	 */
	Route::get('links/{id}/toggle', ['as' => 'links.toggle','uses' => 'LinksController@toggle']);
	Route::resource('links', 'LinksController');
	/*
	|--------------------------------------------------------------------------
	| Links
	|--------------------------------------------------------------------------
	 */
	Route::resource('feedback', 'FeedbackController');


	Route::get('{name}', ['as' => 'links.showbyshorttitle','uses' => 'LinksController@showByShortTitle']);
});

/*
|--------------------------------------------------------------------------
| REST API
|--------------------------------------------------------------------------
*/
Route::group(
[
	'namespace' => 'Zeropingheroes\Lanager\Http\Api\v1',
],
function()
{
	Route::api(['version' => 'v1'], function () {
		if (Config::get("lanager/api.origins",null) != null) {
			if  (count(Config::get("lanager/api.origins") > 1)) {
				foreach(Config::get("lanager/api.origins") as $origin) {
					if ($_SERVER['HTTP_ORIGIN'] == $origin)
						header("Access-Control-Allow-Origin: ".$origin);
				}
			}
			else {
				header("Access-Control-Allow-Origin: ".Config::get("lanager/api.origins","*"));
			}
			header("Access-Control-Allow-Methods: ".Config::get("lanager/api.methods","GET, OPTIONS"));
			header("Access-Control-Allow-Credentials: ".Config::get("lanager/api.credentials",'false'));
		}

		Route::resource('achievements',			'AchievementsController',		['except' => ['create', 'edit'] ]);
		Route::resource('user-achievements',	'UserAchievementsController',	['except' => ['create', 'edit'] ]);
		Route::resource('events',				'EventsController',				['except' => ['create', 'edit'] ]);
		Route::resource('event-signups',		'EventSignupsController',		['except' => ['create', 'edit', 'update'] ]);
		Route::resource('event-types',			'EventTypesController',			['except' => ['create', 'edit'] ]);
		Route::resource('pages',				'PagesController',				['except' => ['create', 'edit'] ]);
		Route::resource('lans',					'LansController',				['except' => ['create', 'edit'] ]);
		Route::resource('shouts',				'ShoutsController',				['except' => ['create', 'edit'] ]);
		Route::resource('roles',				'RolesController',				['except' => ['create', 'edit'] ]);
		Route::resource('user-roles',			'UserRolesController',			['except' => ['create', 'edit', 'update'] ]);
		Route::resource('users',				'UsersController',				['except' => ['create', 'store', 'edit', 'update'] ]);
		Route::resource('application-usage',	'ApplicationUsageController',	['except' => ['create', 'show', 'store', 'edit', 'update', 'destroy'] ]);
	    Route::resource('logs',					'LogsController',				['except' => ['create', 'store', 'edit', 'update', 'destroy'] ]);
    	Route::resource('projector',     'ProjectorController',      ['except' => ['create', 'edit'] ]);
		
		// List of endpoints
		Route::get('/', ['as' => 'api.index', function () {
			$routes = Route::getApiGroups()->getByVersion('v1');

			$endpoints = [];
			foreach ($routes as $route) {
				$endpoints['endpoints'][] =
				[
					'path' => $route->getPath(),
					'methods' => $route->getMethods()
				];
			}
			return Response::make($endpoints, 200, [], ['options' => JSON_PRETTY_PRINT] );
		}]);
	});
});

/*
|--------------------------------------------------------------------------
| Index
|--------------------------------------------------------------------------
*/
Route::get('/', function()
{
	return Redirect::to(Config::get('lanager/config.startPage','shouts'));
});
