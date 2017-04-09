<?php namespace Zeropingheroes\Lanager\Domain\Feedback;

use Zeropingheroes\Lanager\Domain\ResourceService;
use Cache;
use Input;

class FeedbackService extends ResourceService {

	protected $model = 'Zeropingheroes\Lanager\Domain\Feedback\Feedback';

	protected $orderBy = [ ['priority', 'desc'], ['created_at','desc'] ];

	public function store( $input )
	{
		$this->setUser();
		if ( ! isset( $input['user_id'] ) ) $input['user_id'] = $this->user->id();
		return parent::store( $input );
	}

	public function destroy( $id )
	{
		return parent::destroy( $id );
	}

	protected function readAuthorised()
	{
		return $this->user->hasRole('Feedback Admin');
	}

	protected function storeAuthorised()
	{
	    return true;
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
    	if ( ! $this->user->hasRole( 'Feedback Admin' ) ) {
      		$this->addFilter( 'where', 'user_id', $this->user->id );
    	}
	}


}
