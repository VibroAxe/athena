<?php namespace Zeropingheroes\Lanager\Domain\Feedback;

use Zeropingheroes\Lanager\Domain\BaseModel;

class Feedback extends BaseModel {

	protected $fillable = ['user_id', 'priority', 'feedback'];

	protected $nullable = ['user_id'];

	/**
	 * A single user achievement (aka award) belongs to a single user
	 * @return object Illuminate\Database\Eloquent\Relations\Relation
	 */
	public function user()
	{
		return $this->belongsTo('Zeropingheroes\Lanager\Domain\Users\User');
	}

	public function priorityAsText() {
		switch ($this->priority) {
			case 0: return "Feedback";
			case 1: return "Enhancement";
			case 2: return "Bug";
			default: return $this->priority;
		}
	}

}
