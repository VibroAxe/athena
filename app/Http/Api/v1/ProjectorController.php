<?php namespace Zeropingheroes\Lanager\Http\Api\v1;

use Zeropingheroes\Lanager\Domain\Projector\ProjectorService;
use Zeropingheroes\Lanager\Domain\Projector\SlideTransformer;
use Zeropingheroes\Lanager\Http\Api\v1\Traits\FlatResourceTrait;

class ProjectorController extends ResourceServiceController {

	use FlatResourceTrait;

	/**
	 * Set the service and transformer classes
	 */
	public function __construct()
	{
		parent::__construct();
		$this->service = new ProjectorService;
		$this->transformer = new SlideTransformer;
	}

}
