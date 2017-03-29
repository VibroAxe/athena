<?php namespace Zeropingheroes\Lanager\Domain\Achievements;

use Zeropingheroes\Lanager\Domain\ResourceService;
use Input;
//use Zeropingheros\Lanager\Domain\ValidationException;
use Zeropingheroes\Lanager\Domain\ValidationException;

class AchievementService extends ResourceService {

	protected $orderBy = [ 'name' ];

	protected $eagerLoad = [ 'userAchievements', 'userAchievements.lan', 'userAchievements.user.state.application' ];

	protected $model = 'Zeropingheroes\Lanager\Domain\Achievements\Achievement';

	protected function readAuthorised()
	{
		return true;
	}

	protected function storeAuthorised()
	{
		return $this->user->hasRole('Achievements Admin');
	}

	protected function updateAuthorised()
	{
		return $this->user->hasRole('Achievements Admin');
	}

	protected function destroyAuthorised()
	{
		return $this->user->hasRole('Achievements Admin');
	}

	protected function validationRulesOnStore( $input )
	{
		return [
			'name'			=> [ 'required', 'max:255', 'unique:achievements,name' ],
			'image'			=> [ 'required' ],
			'description'	=> [ 'required', 'max:255' ],
		];
	}

	protected function validationRulesOnUpdate( $input )
	{
		$rules = $this->validationRulesOnStore( $input );

		// Exclude current achievement from uniqueness test
		$rules['name'] = [ 'required', 'max:255', 'unique:achievements,name,' . $input['id'] ];

		return $rules;
	}

	protected function domainRulesOnRead( $input )
	{
		// Todo: re-add visible field to achievements table
		//if ( ! $this->user->hasRole( 'Achievements Admin' ) )
			//$this->addFilter( 'where', 'visible', true );
	}

	//override ResourceService' store and update methods to handle image file uploading

	/**
	 * Store a new resource item
	 * @param  array $input Raw user input
	 * @return boolean
	 */
	public function store( $input )
	{
		$this->setUser();
	
		$model = $this->newModelInstance();
	
		$model = $model->fill( $input );

		if ( Input::hasFile('image_file') ) {
			if (Input::file('image_file')->isValid()) {
				$imageInfo = getimagesize(Input::file('image_file'));
				if ((substr($imageInfo['mime'],0,5) === "image") && ($imageInfo[0] <= 128) && ($imageInfo[1] <= 128)) {
					//Todo: Check if image file is image / correct size
					$newname = $this->generateUniqueName(public_path()."/upload/achievements/","",Input::file('image_file')->getClientOriginalExtension());
					if ($path = Input::file('image_file')->move(public_path()."/upload/achievements/",$newname)) {
						$model->image = str_replace(public_path(),"",$path);
					} else {
						unlink(public_path()."/upload/achievements/".$newname);
						throw new ValidationException("Validation Error","Achievement Image was invalid");
					}
				} else {
					//image wrong size
					throw new ValidationException("Validation Error","Achievement Image was invalid (Not an image or incorrect size)");
				}
			}
		}
	
		$this->runChecks( 'store', $model->toArray() );
	
		$model->save();
	
		return $model->toArray();
	}

	/**
	 * Update an existing resource item by ID
	 * @param  integer $id    Item's ID
	 * @param  array $input   Raw user input
	 * @return boolean
	 */
	public function update( $id, $input )
	{
		$this->setUser();
	
		$model = $this->get( $this->newModelInstance(), $id );
	
		$model = $model->fill( $input );

		if ( Input::hasFile('image_file') ) {
			if (Input::file('image_file')->isValid()) {
				$imageInfo = getimagesize(Input::file('image_file'));
				if ((substr($imageInfo['mime'],0,5) === "image") && ($imageInfo[0] <= 128) && ($imageInfo[1] <= 128)) {
					//Todo: Check if image file is image / correct size
					$orig = $model->image;
					$newname = $this->generateUniqueName(public_path()."/upload/achievements/","",Input::file('image_file')->getClientOriginalExtension());
					if ($path = Input::file('image_file')->move(public_path()."/upload/achievements/",$newname)) {
						$model->image = str_replace(public_path(),"",$path);
						if ($orig != "") {
							try {
								unlink(public_path().$orig);
							} catch (Exception $ex) {}
						}
					} else {
						unlink(public_path()."/uploads/achievements/".$newname);
						//failed to update
						throw new ValidationException("Validation Error","Achievement Image was invalid");
					}
				} else {
					//image wrong size
					throw new ValidationException("Validation Error","Achievement Image was invalid (Not an image or incorrect size)");
				}
			}
		}
	
		$this->runChecks( 'update', $model->toArray(), $model->getOriginal() );
	
		$model->save();

		return $model->toArray();
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
