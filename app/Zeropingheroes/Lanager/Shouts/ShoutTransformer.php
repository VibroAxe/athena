<?php namespace Zeropingheroes\Lanager\Shouts;

use League\Fractal;

use Zeropingheroes\Lanager\Users\UserTransformer;

class ShoutTransformer extends Fractal\TransformerAbstract {

	protected $defaultIncludes = [
		'user',
	];

	public function transform(Shout $shout)
	{
		return [
			'id'			=> (int) $shout->id,
			'content'		=> $shout->content,
			'pinned'		=> (bool) $shout->pinned,
			'links'			=> [
				[
					'rel' => 'self',
					'uri' => ('/shouts/'. $shout->id),
				]
			],
		];
	}

	public function includeUser(Shout $shout)
	{
		return $this->collection($shout->user()->get(), new UserTransformer);
	}

}