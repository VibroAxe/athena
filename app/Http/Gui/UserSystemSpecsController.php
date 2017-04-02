<?php namespace Zeropingheroes\Lanager\Http\Gui;

use Zeropingheroes\Lanager\Domain\UserSystemSpecs\UserSystemSpecsService;
use Zeropingheroes\Lanager\Domain\User\UserService;
use View;
use Redirect;
use Input;

class UserSystemSpecsController extends ResourceServiceController {

	/**
	 * Set the controller's service
	 */
	public function __construct()
	{
		$this->service = new UserSystemSpecsService;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index( $specId )
	{
		$spec[] = $this->service->single( $specId );

		return View::make('user-systemspecs.partials.list')
			->with('systemSpecs',$spec);
	}

	public function store()
	{
		$input = Input::all();
//		$input['event_id'] = func_get_arg(0);

		return parent::processStore( $input );
	}

	public function update()
	{
		$this->service = $this->service->filterByEvent( func_get_arg(0) );

		return parent::processUpdate( func_get_arg(1), Input::get() );
	}

	public function destroy()
	{
		$this->service = $this->service->filterByEvent( func_get_arg(0) );

		return parent::processDestroy( func_get_arg(1) );
	}

	protected function redirectAfterStore( $resource )
	{
		return Redirect::route('users.show', ['user' => Auth::User()->id, 'tab' => 'system-specs']);
	}

	protected function redirectAfterUpdate( $resource )
	{
		return $this->redirectAfterStore( $resource );
	}

	protected function redirectAfterDestroy( $resource )
	{
		return $this->redirectAfterStore( $resource );
	}

}
