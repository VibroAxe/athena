<?php namespace Zeropingheroes\Lanager\Domain\UserOAuths;

use Zeropingheroes\Lanager\Domain\BaseModel;

class UserOAuth extends BaseModel {

	protected $fillable = ['user_id', 'service', 'service_id', 'username', 'token', 'tokenexpires', 'refreshtoken', 'avatar'];

	protected $nullable = ['service_id', 'username', 'avatar', 'token', 'tokenexpires', 'refreshtoken'];

	protected $hidden = ['token', 'tokenexpires' ,'refreshtoken'];

	/**
	 * A single user achievement (aka award) belongs to a single user
	 * @return object Illuminate\Database\Eloquent\Relations\Relation
	 */
	public function user()
	{
		return $this->belongsTo('Zeropingheroes\Lanager\Domain\Users\User');
	}

}
