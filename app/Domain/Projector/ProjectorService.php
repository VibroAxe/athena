<?php namespace Zeropingheroes\Lanager\Domain\Projector;

use Zeropingheroes\Lanager\Domain\ResourceService;
use Cache;

class ProjectorService extends ResourceService {

	protected $model = 'Zeropingheroes\Lanager\Domain\Projector\Slide';

	protected $orderBy = [ ['position', 'asc'], ['created_at','asc'] ];

	public function store( $input )
	{
		return parent::store( $input );
	}

	public function update( $id, $input )
	{
		return parent::update( $id, $input );
	}

	public function destroy( $id )
	{
		return parent::destroy( $id );
	}

	protected function readAuthorised()
	{
		return true;
	}

	protected function storeAuthorised()
	{
    return $this->user->hasRole( 'Projector Admin' );
	}

	protected function updateAuthorised()
	{
		return $this->user->hasRole( 'Projector Admin' );
	}

	protected function destroyAuthorised()
	{
		return $this->user->hasRole( 'Projector Admin' );
	}

	protected function validationRulesOnStore( $input )
	{
		return [
			'title'		=> [ 'required', 'max:255' ],
			'position'	=> [ 'numeric', 'min:0' ],
			'published'	=> [ 'boolean' ],
		];
	}

	protected function validationRulesOnUpdate( $input )
	{
		return $this->validationRulesOnStore( $input );
	}

	protected function domainRulesOnRead( $input )
	{
		if ( ! $this->user->hasRole( 'Projector Admin' ) )
			$this->addFilter( 'where', 'published', true );
	}

}
