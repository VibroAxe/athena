<?php namespace Zeropingheroes\Lanager\Domain\MPUK;

use Zeropingheroes\Lanager\Domain\ResourceService;
use Cache;
use Input;

class MPUKUserService extends ResourceService {

	protected $model = 'Zeropingheroes\Lanager\Domain\MPUK\MPUKUser';

	protected $orderBy = [ ['total', 'desc'], ['created_at','desc'] ];

	public function store( $input )
	{
		return false;
	}

	public function destroy( $id )
	{
		return false;
	}

	protected function readAuthorised()
	{
		return true;
	}

	protected function storeAuthorised()
	{
	    return false;
	}

	protected function updateAuthorised()
	{
		return $this->user->hasRole( 'Feedback Admin' );
	}

	protected function destroyAuthorised()
	{
		return $this->user->hasRole( 'Feedback Admin' );
	}

	protected function validationRulesOnStore( $input )
	{
		return [
			'feedback'		=> [ 'required', 'max:255' ],
			'priority'		=> [ 'required' ],
		];
	}

	protected function validationRulesOnUpdate( $input )
	{
		return $this->validationRulesOnStore( $input );
	}

	protected function domainRulesOnRead( $input )
	{
	}


}
