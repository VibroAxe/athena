<?php namespace Zeropingheroes\Lanager\Domain\Uploads;

use Zeropingheroes\Lanager\Domain\BaseModel;
use ExpressiveDate;

class Upload extends BaseModel {

	protected $fillable = [ 'title', 'url' ];

	protected $nullable = [  ];

	protected $optional = [ 'published', ];

}
