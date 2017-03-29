<?php namespace Zeropingheroes\Lanager\Domain\Uploads;

use League\Fractal\TransformerAbstract;

class UploadTransformer extends TransformerAbstract {

	/**
	 * Transform resource into standard output format with correct typing
	 * @param  object BaseModel   Resource being transformed
	 * @return array              Transformed object array ready for output
	 */
	public function transform(Upload $Upload)
	{
		return [
			'id'			=> (int) $Upload->id,
			'title'			=> $Upload->title,
			'url'			=> url().$Upload->url,
			];
	}
}
