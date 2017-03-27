<?php namespace Zeropingheroes\Lanager\Domain\Links;

use Zeropingheroes\Lanager\Domain\BaseModel;
use ExpressiveDate;

class Link extends BaseModel {

	protected $fillable = [ 'title', 'shorttitle', 'url', 'published' ];

	protected $nullable = [  ];

	protected $optional = [ 'published', ];

}
