<?php namespace Zeropingheroes\Lanager\Http\Gui;

use Zeropingheroes\Lanager\Domain\Links\LinkService;
use View;
use Redirect;
use Auth;
use App;

class LinksController extends ResourceServiceController {

	/**
	 * Set the controller's service
	 */
	public function __construct()
	{
		$this->service = new LinkService;
	}

  /**
	* Display a listing of the resource.
   	*
   	* @return Response
   	*/
  	public function index() 
	{
		if ( Auth::user() == null || ! Auth::user()->hasRole( 'Links Admin' )) {
			$links = null;
		} else {
			$links = $this->service->all();
		}

		return View::make( 'links.index' )
			->with( 'title', 'Manage Links' )
			->with( 'links', $links );
	}

	/*
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make( 'links.create' )
					->with( 'title','Create Link' )
					->with( 'link', null );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show( $id )
	{
    	$link = $this->service->single( $id );

    	return Redirect::to($link['url']);
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param  string  $id
	 * @return Response
	 */
	public function showByShortTitle( $name )
	{
		$this->service->addFilter('shorttitle',$name);
		$link = $this->service->all()->take(1)->first();
		if ($link != null) {
			return Redirect::to($link->url);
		} else {
			App::abort(404);
		}
	}



  /**
   * Toggle active status for the specified resource
   *
   * @param  int  $id
   * @return Response
   */
  public function toggle( $id ) {
    $link = $this->service->single($id);
    if ($link->published == 1) {
      $link->published = 0;
    } else {
      $link->published = 1;
    }
    $link->save();
    return Redirect::route( 'links.index' );
  }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit( $id )
	{
		return View::make( 'link.edit' )
					->with( 'title', 'Edit Link' )
					->with( 'link', $this->service->single( $id ) );
	}

	protected function redirectAfterStore( $resource )
	{
    //return Redirect::route( 'projector.show', $resource['id'] );
    return Redirect::route( 'links.index' );
	}

	protected function redirectAfterUpdate( $resource )
	{
		return $this->redirectAfterStore( $resource );
	}

	protected function redirectAfterDestroy( $resource )
	{
		return Redirect::route( 'links.index' );
	}

}
