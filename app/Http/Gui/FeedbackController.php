<?php namespace Zeropingheroes\Lanager\Http\Gui;

use Zeropingheroes\Lanager\Domain\Feedback\FeedbackService;
use View;
use Redirect;
use Authority;

class FeedbackController extends ResourceServiceController {

	/**
	 * Set the controller's service
	 */
	public function __construct()
	{
		$this->service = new feedbackService;
	}

  /**
   * Display the main feedback interface
   *
   * @return Response
   */
	public function index() {
		if (Authority::can('manage','feedback')) {
		$feedback = $this->service->all();
		
    return View::make('feedback.index')
		->with('title', 'feedback')
		->with('feedback', $feedback);
		} else {
			return Redirect::route('feedback.create');
		}
  }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make( 'feedback.create' )
					->with( 'title','Create feedback' )
					->with( 'feedback', null );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show( $id )
	{
    $feedback = $this->service->single( $id );

		  return View::make( 'feedback.show' )
					->with( 'title', 'Feedback' )
          			->with( 'feedback', $feedback );
  }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit( $id )
	{
		return View::make( 'feedback.edit' )
					->with( 'title', 'Edit feedback' )
					->with( 'feedback', $this->service->single( $id ) );
	}

	protected function redirectAfterStore( $resource )
	{
		if (Authority::can('manage', 'feedback')) {
			return Redirect::route('feedback.index');
		} else {
			return Redirect::to( '/' );
		}
	}

	protected function redirectAfterUpdate( $resource )
	{
		return $this->redirectAfterStore( $resource );
	}

	protected function redirectAfterDestroy( $resource )
	{
		return Redirect::to( '/' );
	}

}
