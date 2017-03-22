<?php
/*
|--------------------------------------------------------------------------
| View Composers
|--------------------------------------------------------------------------
*/

View::composer('layouts.default.nav', function($view)
{
	// Info (cached until a page is edited)
	$pageMenus = Cache::rememberForever('pageMenus', function()
	{
		$pages = Zeropingheroes\Lanager\Domain\Pages\Page::whereNull('parent_id')->where('menu','!=','')->where('published', true)->orderBy(DB::raw('ISNULL(position)'))->orderBy('position')->get();
		if ( $pages->count() )
    {
			foreach($pages as $page)
      {
				$menuItems[$page['menu']][] =
				[
					'title' => $page['title'],
					'link' => URL::route('pages.show', ['id' => $page->id, 'prettyname' => str_replace([" "],["-"],$page->title)]),
				];
      }
      foreach($menuItems as &$menu) 
      {
        echo "Config status : ".Config::get('lanager/nav.showAllPages');
        if ( Config::get('lanager/nav.showAllPages',false) ) {
			    $menu[] = [
			  	  'title' => 'All Pages',
			  	  'link' => URL::route('pages.index'),
          ];
        }
      }
		}
		else
		{
			$menuItems = []; // TODO: deal with no pages better
    }
		return $menuItems;
	});


	$view->with('pageMenus', $pageMenus);

	// Links
	$view->with('links', Config::get('lanager/links'));
});
