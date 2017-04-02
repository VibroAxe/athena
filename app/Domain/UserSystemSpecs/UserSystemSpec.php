<?php namespace Zeropingheroes\Lanager\Domain\UserSystemSpecs;

use Zeropingheroes\Lanager\Domain\BaseModel;

class UserSystemSpec extends BaseModel {

	protected $fillable = ['user_id', 'element', 'contents'];

	/**
	 * A single user achievement (aka award) belongs to a single user
	 * @return object Illuminate\Database\Eloquent\Relations\Relation
	 */
	public function user()
	{
		return $this->belongsTo('Zeropingheroes\Lanager\Domain\Users\User');
	}

}
