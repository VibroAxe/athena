<?php namespace Zeropingheroes\Lanager\Domain\Links;

use Zeropingheroes\Lanager\Domain\ResourceService;
use Cache;
use Input;

class LinkService extends ResourceService {

	protected $model = 'Zeropingheroes\Lanager\Domain\Links\Link';

	protected $orderBy = [ ['created_at','asc'] ];

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
	    return $this->user->hasRole( 'Links Admin' );
	}

	protected function updateAuthorised()
	{
		return $this->user->hasRole( 'Links Admin' );
	}

	protected function destroyAuthorised()
	{
		return $this->user->hasRole( 'Links Admin' );
	}

	protected function validationRulesOnStore( $input )
	{
		return [
			'title'		=> [ 'required', 'max:255' ],
			'shorttitle' => [ 'required', 'max:255' ],
			'published'	=> [ 'boolean' ],
		];
	}

	protected function validationRulesOnUpdate( $input )
	{
		return $this->validationRulesOnStore( $input );
	}

	protected function domainRulesOnRead( $input )
	{
    	if ( ! $this->user->hasRole( 'Links Admin' ) ) {
      		$this->addFilter( 'where', 'published', true );
    	}
	}


}
