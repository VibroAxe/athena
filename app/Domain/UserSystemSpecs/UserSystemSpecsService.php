<?php namespace Zeropingheroes\Lanager\Domain\EventSignups;

use Zeropingheroes\Lanager\Domain\ResourceService;
use Zeropingheroes\Lanager\Domain\Users\UsersService;
use Zeropingheroes\Lanager\Domain\AuthorisationException;
use Zeropingheroes\Lanager\Domain\ServiceFilters\FilterableByUser;
use DomainException;

class UserSystemSpecsService extends ResourceService {

//	use FilterableByTimestamps;

//	use FilterableByUser;

	protected $model = 'Zeropingheroes\Lanager\Domain\UserSystemSpecs\UserSystemSpec';

	protected $eagerLoad = [ 'user.state.application' ];

	public function store( $input )
	{
		$this->setUser();

		if ( ! isset( $input['user_id'] ) ) $input['user_id'] = $this->user->id();

		return parent::store( $input );
	}

	/**
	 * Filter by a given event
	 * @param  integer $eventId  event's ID
	 * @return self
	 */
	public function filterByUser( $userId )
	{
		$this->addFilter( 'where', 'user_id', $userId );

		return $this;
	}

	protected function readAuthorised()
	{
		return true;
	}

	protected function storeAuthorised()
	{
		return $this->user->isAuthenticated();
	}

	protected function destroyAuthorised()
	{
		return $this->user->isAuthenticated();
	}

	protected function validationRulesOnStore( $input )
	{
		return [
			'user_id'		=> [ 'required', 'exists:users,id' ],
		];
	}

	protected function validationRulesOnUpdate( $input )
	{
		return $this->validationRulesOnStore( $input );
	}

	protected function domainRulesOnStore( $input )
	{
		if ( $this->input['user_id'] != $this->user->id() )
			throw new AuthorisationException( 'You may only edit your own system' );
	}

	protected function domainRulesOnDestroy( $input )
	{
			if ( $input['user_id'] != $this->user->id() )
				throw new AuthorisationException( 'You may only delete your own event signups' );
	}

}
