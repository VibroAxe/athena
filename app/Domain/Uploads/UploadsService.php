<?php namespace Zeropingheroes\Lanager\Domain\Uploads;

use Zeropingheroes\Lanager\Domain\ResourceService;
use Cache;
use Input;

class UploadsService extends ResourceService {

	protected $model = 'Zeropingheroes\Lanager\Domain\Uploads\Upload';

	protected $orderBy = [ ['created_at','asc'] ];

	public function store( $input )
	{
		$this->setUser();

		$model = $this->newModelInstance();

		$model = $model->fill( $input );

		if ( Input::hasFile('upload_file') ) {
			if (Input::file('upload_file')->isValid()) {
					$newname = $this->generateUniqueName(public_path()."/upload/general/","",Input::file('upload_file')->getClientOriginalExtension());
					if ($path = Input::file('upload_file')->move(public_path()."/upload/general/",$newname)) {
						$model->url = str_replace(public_path(),"",$path);
					} else {
						unlink(public_path()."/upload/general/".$newname);
					}
			}
		}
		
		$this->runChecks( 'store', $model->toArray() );
		
		$model->save();
		
		return $model->toArray();
	}

	public function update( $id, $input )
	{
		$this->setUser();

		$model = $this->get( $this->newModelInstance(), $id );

		$model = $model->fill( $input );

		if ( Input::hasFile('upload_file') ) {
			if (Input::file('upload_file')->isValid()) {
					if ($model->url != "") {
						$newname = $model->url;
					} else {
						$newname = $this->generateUniqueName(public_path()."/upload/general/","",Input::file('upload_file')->getClientOriginalExtension());
					}
					if ($path = Input::file('upload_file')->move(public_path()."/upload/general/",$newname)) {
						$model->url = str_replace(public_path(),"",$path);
					} else {
						unlink(public_path()."/upload/general/".$newname);
					}
			}
		}
		
		$this->runChecks( 'store', $model->toArray() );
		
		$model->save();
		
		return $model->toArray();
	}

	/**
	 * Destroy an existing resource item by ID
	 * @param  integer $id    Item's ID
	 * @return boolean
	 */
	public function destroy( $id )
	{
		$this->setUser();

		$model = $this->get( $this->newModelInstance(), $id );

		$this->runChecks( 'destroy', $model->toArray() );

		if (file_exists(public_path().$model->url)) {
			try {
				unlink (public_path().$model->url);
			} catch (Exception $ex) {
			}
		}

		$model->delete();

		return $model->toArray();
	}

	protected function readAuthorised()
	{
		return true;
	}

	protected function storeAuthorised()
	{
    return $this->user->hasRole( 'Uploads Admin' );
	}

	protected function updateAuthorised()
	{
		return $this->user->hasRole( 'Uploads Admin' );
	}

	protected function destroyAuthorised()
	{
		return $this->user->hasRole( 'Uploads Admin' );
	}

	protected function validationRulesOnStore( $input )
	{
		return [
			'title'		=> [ 'required', 'max:255' ],
			'url'		=> [ 'required', ],
		];
	}

	protected function validationRulesOnUpdate( $input )
	{
		return $this->validationRulesOnStore( $input );
	}

	protected function domainRulesOnRead( $input )
	{
	}

	private function generateUniqueName($dir, $prefix, $extension) {
		$name = $prefix.md5(time().rand());
		if ($extension != "")
			$name = $name.".".$extension;
		if (!file_exists($dir."/".$name)) {
			$handle = fopen($dir.'/'.$name, "w");
			fclose($handle);
			return $name;
		} else {
			return $this->generateUniqueName($dir, $prefix, $extension);
		}
	}

}
