<?php namespace Zeropingheroes\Lanager\Domain\Projector;

use Zeropingheroes\Lanager\Domain\BaseModel;

class Slide extends BaseModel {

	protected $fillable = [ 'parent_id', 'title', 'url', 'content', 'position', 'published', 'timespan', 'startdate', 'enddate', 'starttime', 'endtime' ];

	protected $nullable = [ 'url', 'content', 'position', 'startdate','enddate', 'starttime', 'endtime' ];

	protected $optional = [ 'published', 'timespan' ];

}
