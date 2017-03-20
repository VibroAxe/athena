<?php namespace Zeropingheroes\Lanager\Domain\Projector;

use League\Fractal\TransformerAbstract;

class SlideTransformer extends TransformerAbstract {

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
      'timespan'  => $slide->timespan,
      'published' => $slide->published,
			'url'			=> (! is_null($slide->url) ? $slide->url : (url().'/projector/'. $slide->id)),
			];
	}
}
