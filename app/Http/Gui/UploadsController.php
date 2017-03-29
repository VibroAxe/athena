<?php namespace Zeropingheroes\Lanager\Http\Gui;

use Zeropingheroes\Lanager\Domain\Uploads\UploadsService;
use View;
use Redirect;

class UploadsController extends ResourceServiceController {

	/**
	 * Set the controller's service
	 */
	public function __construct()
	{
		$this->service = new UploadsService;
	}

  /**
   * Display a listing of the Uploads Resource
   *
   * @return Response
   */
  	public function index() {

		$uploads = $this->service->all();

		return View::make( 'uploads.index' )
					->with( 'title', 'Manage uploads' )
					->with( 'uploads', $uploads );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make( 'uploads.create' )
					->with( 'title','Upload new file' )
					->with( 'upload', null );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show( $id )
	{
    	$upload = $this->service->single( $id );

      	return Redirect::to($upload['url']);
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit( $id )
	{
		return View::make( 'uploads.edit' )
					->with( 'title', 'Upload replacement' )
					->with( 'upload', $this->service->single( $id ) );
	}

	protected function redirectAfterStore( $resource )
	{
    //return Redirect::route( 'uploads.show', $resource['id'] );
    return Redirect::route( 'uploads.index' );
	}

	protected function redirectAfterUpdate( $resource )
	{
		return $this->redirectAfterStore( $resource );
	}

	protected function redirectAfterDestroy( $resource )
	{
		return Redirect::route( 'uploads.index' );
	}

}
