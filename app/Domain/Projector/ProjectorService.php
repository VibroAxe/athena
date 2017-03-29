<?php namespace Zeropingheroes\Lanager\Domain\Projector;

use Zeropingheroes\Lanager\Domain\ResourceService;
use Cache;
use Input;

class ProjectorService extends ResourceService {

	protected $model = 'Zeropingheroes\Lanager\Domain\Projector\Slide';

	protected $orderBy = [ ['position', 'asc'], ['created_at','asc'] ];

	public function store( $input )
	{
		$this->setUser();

		$model = $this->newModelInstance();

		$model = $model->fill( $input );

		if ( Input::hasFile('image_file') ) {
			if (Input::file('image_file')->isValid()) {
				if (true) {
					//Todo: Check if image file is image / correct size
					$newname = $this->generateUniqueName(public_path()."/upload/slides/","",Input::file('image_file')->getClientOriginalExtension());
					if ($path = Input::file('image_file')->move(public_path()."/upload/slides/",$newname)) {
						$model->url = str_replace(public_path(),"",$path);
					} else {
						unlink(public_path()."/upload/slides/".$newname);
					}
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

		if ( Input::hasFile('image_file') ) {
			if (Input::file('image_file')->isValid()) {
				if (true) {
					//Todo: Check if image file is image / correct size
					$newname = $this->generateUniqueName(public_path()."/upload/slides/","",Input::file('image_file')->getClientOriginalExtension());
					if ($path = Input::file('image_file')->move(public_path()."/upload/slides/",$newname)) {
						$model->url = str_replace(public_path(),"",$path);
					} else {
						unlink(public_path()."/upload/slides/".$newname);
					}
				}
			}
		}
		
		$this->runChecks( 'store', $model->toArray() );
		
		$model->save();
		
		return $model->toArray();
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
    if ( ! $this->user->hasRole( 'Projector Admin' ) ) {
        $filter =  "(".
                    "`published` = '1'".
                    ") AND (".
                    "(`enddate` IS NULL) OR (`enddate` >= '".date('Y-m-d H:i:s')."')".
                    ") AND (".
                    "(`startdate` IS NULL) OR (`startdate` <= '".date('Y-m-d H:i:s')."')".
                    ")";
//      $this->addFilter( 'where', 'published', true );
        $this->addFilter('whereRaw',$filter);
    }
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
