<?php namespace Zeropingheroes\Lanager\Domain\Links;

use League\Fractal\TransformerAbstract;

class LinkTransformer extends TransformerAbstract {

	/**
	 * Transform resource into standard output format with correct typing
	 * @param  object BaseModel   Resource being transformed
	 * @return array              Transformed object array ready for output
	 */
	public function transform(Slide $slide)
	{
		return [
			'id'			=> (int) $slide->id,
			'title'			=> $slide->title,
			'published' => $slide->published,
			'url'			=> (! is_null($slide->url) ? $slide->url : (url().'/projector/'. $slide->id)),
			'startdate' => $slide->startdate,
			'enddate' => $slide->enddate,
			'isactive' => $slide->isActive(),
			];
	}
}
