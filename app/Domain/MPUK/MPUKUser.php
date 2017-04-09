<?php namespace Zeropingheroes\Lanager\Domain\MPUK;

use Zeropingheroes\Lanager\Domain\BaseModel;

class MPUKUser extends BaseModel {

	protected $fillable = ['username', 'fullname', 'email', 'total', 'rank'];

}
