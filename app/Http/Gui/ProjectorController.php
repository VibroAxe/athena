<?php namespace Zeropingheroes\Lanager\Http\Gui;

use Zeropingheroes\Lanager\Domain\Projector\ProjectorService;
use View;
use Redirect;

class ProjectorController extends ResourceServiceController {

	/**
	 * Set the controller's service
	 */
	public function __construct()
	{
		$this->service = new ProjectorService;
	}

  /**
   * Display the main projector interface
   *
   * @return Response
   */
  public function index() {
    return View::make('projector.index')
          ->with('title', 'Projector');
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function manage()
	{
		$slides = $this->service->all();

		return View::make( 'projector.manage' )
					->with( 'title', 'Manage Slides' )
					->with( 'slides', $slides );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make( 'projector.create' )
					->with( 'title','Create Slide' )
					->with( 'slide', null );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show( $id )
	{
    $slide = $this->service->single( $id );

    if ( $slide['url'] != null ) {
      return Redirect::to($slide['url']);
    } else {

		  return View::make( 'projector.show' )
					->with( 'title', $slide->title )
          ->with( 'slide', $slide );
    }
  }

  /**
   * Toggle active status for the specified resource
   *
   * @param  int  $id
   * @return Response
   */
  public function toggle( $id ) {
    $slide = $this->service->single($id);
    if ($slide->published == 1) {
      $slide->published = 0;
    } else {
      $slide->published = 1;
    }
    $slide->save();
    return Redirect::route( 'projector.manage' );
  }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit( $id )
	{
		return View::make( 'projector.edit' )
					->with( 'title', 'Edit Slide' )
					->with( 'slide', $this->service->single( $id ) );
	}

	protected function redirectAfterStore( $resource )
	{
    //return Redirect::route( 'projector.show', $resource['id'] );
    return Redirect::route( 'projector.manage' );
	}

	protected function redirectAfterUpdate( $resource )
	{
		return $this->redirectAfterStore( $resource );
	}

	protected function redirectAfterDestroy( $resource )
	{
		return Redirect::route( 'projector.manage' );
	}

}
