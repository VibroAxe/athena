<?php namespace Zeropingheroes\Lanager\Domain\Users;

use Zeropingheroes\Lanager\Domain\BaseModel;
use Illuminate\Auth\UserInterface;
use Laracasts\Presenter\PresentableTrait;
use DB;
use Config;
use Carbon\Carbon;

use Zeropingheroes\Lanager\Domain\Lans\LanService;

class User extends BaseModel implements UserInterface {

	use PresentableTrait;

	protected $fillable = ['username', 'steam_id_64', 'steam_visibility', 'ip', 'avatar', 'visible'];

	protected $optional = ['steam_visibility', 'visible'];

	protected $hidden = ['remember_token', 'api_key'];

	/**
	 * Presenter class responsible for presenting this model's fields
	 * @var string
	 */
	protected $presenter = 'Zeropingheroes\Lanager\Domain\Users\UserPresenter';

	
	/*
	 * A single user has many System Specs
	 * @return object Illuminate\Database\Eloquent\Relations\Relation
	 */
	public function SystemSpecs() {
		return $this->hasMany('Zeropingheroes\Lanager\Domain\UserSystemSpecs\UserSystemSpec');
	}


	/*
	 * A single user has many OAuthUser
	 */
	public function OAuths($service = null) {
		if ($service == null) {
			return $this->hasMany('Zeropingheroes\Lanager\Domain\UserOAuths\UserOAuth');
		} else {
			return $this->hasMany('Zeropingheroes\Lanager\Domain\UserOAuths\UserOAuth')->where("service",$service);
		}
	}

	/**
	 * A single user has many shouts
	 * @return object Illuminate\Database\Eloquent\Relations\Relation
	 */
	public function shouts()
	{
		return $this->hasMany('Zeropingheroes\Lanager\Domain\Shouts\Shout');
	}

	/**
	 * A single user has many user achievements (aka awards)
	 * @return object Illuminate\Database\Eloquent\Relations\Relation
	 */
	public function userAchievements()
	{
		return $this->hasMany('Zeropingheroes\Lanager\Domain\UserAchievements\UserAchievement');
	}

	/**
	 * A single user has many roles
	 * @return object Illuminate\Database\Eloquent\Relations\Relation
	 */
	public function roles()
	{
		return $this->belongsToMany('Zeropingheroes\Lanager\Domain\Roles\Role', 'user_roles')->withTimestamps();
	}

	/**
	 * A single user has many event signups
	 * @return object Illuminate\Database\Eloquent\Relations\Relation
	 */
	public function eventSignups()
	{
		return $this->hasMany('Zeropingheroes\Lanager\Domain\EventSignups\EventSignup');
	}

	/**
	 * A single user has many states
	 * @return object Illuminate\Database\Eloquent\Relations\Relation
	 */
	public function states()
	{
		return $this->hasMany('Zeropingheroes\Lanager\Domain\States\State');
	}

	/**
	 * Pseudo-relation: A single user's most recent state
	 * @return object Illuminate\Database\Eloquent\Relations\Relation
	 */
	public function state()
	{
		$start = Carbon::createFromTimeStamp(time()-(Config::get('lanager/steam.pollingInterval')));
		$end = Carbon::createFromTimeStamp(time()+(Config::get('lanager/steam.pollingInterval')));

		return $this->hasOne('Zeropingheroes\Lanager\Domain\States\State')
					->join(
						DB::raw('(
								SELECT max(created_at) max_created_at, user_id
								FROM states
								WHERE created_at
									BETWEEN "'.$start.'"
									AND 	"'.$end.'"
								GROUP BY user_id
								) s2'),
						function($join)
						{
							$join->on('states.user_id', '=', 's2.user_id')
								 ->on('states.created_at', '=', 's2.max_created_at');
						})
					->orderBy('states.user_id');
	}

	/**
	 * Check if the user has the specified role assigned to them
	 * @param  string  $requiredRoleName Role name
	 * @return boolean      true if user has role, false otherwise
	 */
	public function hasRole($requiredRoleName) 
	{
		foreach($this->roles as $assignedRole)
		{
			// If the user is assigned the "admin" role, let them do everything
			// except things that require superadmin acccess
			if ( $assignedRole->name == 'Admin' AND $requiredRoleName != 'Super Admin' )
				return true;

			// If the user is assigned the "super admin" role, let them do everything
			if ( $assignedRole->name == 'Super Admin' )
				return true;

			// Otherwise just check if they have the role
			if ($assignedRole->name === $requiredRoleName) 
				return true;
		}
		return false;
	}

	/**
	 * Check if the user is an administrator of any kind
	 * @return boolean		true if user is an admin, false otherwise
	 */
	public function isAdmin()
	{
		foreach($this->roles as $role)
		{
			if (str_contains(strtolower($role->name), 'admin'))
			{
				return true;
			}
		}
		return false;
	}

	/*
	|--------------------------------------------------------------------------------
	| Redundant code below due to implementing Laravel's UserInterface contract...
	|--------------------------------------------------------------------------------
	*/

	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	public function getAuthPassword()
	{
		return $this->password;
	}

	public function getRememberToken()
	{
		return $this->remember_token;
	}

	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	public function getReminderEmail()
	{
		return $this->email;
	}

	public function checkAndUpdateAchievements($lifetime=false) {
		//This code will check criteria for auto achievements and assign if not already granted
		//
		//Event attendance
		$lanservice = new LanService;
		$lanservice->addFilter('where', 'published', '1');
		$lanservice->addFilter('whereRaw','start < Now() AND Now() < end');
		$currentlan = $lanservice->all();
		if (count($currentlan)) {
			foreach ($currentlan as $lan) {
				//Lan is on
				if ($lan->achievement_id != null) {
					//does the user already have the achievement?
					if (count($this->userAchievements()->where('lan_id',$lan->id)->where('achievement_id',$lan->achievement_id)->first()) == 0) {
						//no
						if ($lan->iprange == null) {
							$ipranges="0.0.0.0/0";
						} else {
							$ipranges = $lan->iprange;
						}
						$ipranges = explode(',',$ipranges);
						foreach ($ipranges as $iprange) {
							echo $iprange;
							if (\Symfony\Component\HttpFoundation\IpUtils::checkIp($this->ip, $iprange)) {
								$achievement = new \Zeropingheroes\Lanager\Domain\UserAchievements\UserAchievement;
								$achievement->achievement_id = $lan->achievement_id;
								$achievement->lan_id = $lan->id;
								$achievement->user_id = $this->id;
								$achievement->save();
								$lifetime=true;
								
								break;
							}
						}
					}
				}
			}
			//use the first lan for any further achievements
			$currentlan = $currentlan[0];
		} else {
			//There is no lan on at the moment. Attempt to find next lan
			$lanservice = new LanService;
			$lanservice->addFilter('where', 'published', '1');
			$lanservice->addFilter('whereRaw', 'start > Now()');
			$currentlan = $lanservice->all()->sortBy(function($lan){return $lan->start;})->first();
			if ($currentlan == null) {
				//there is no lan scheduled. Attempt to find the last lan
				$lanservice = new LanService;
				$lanservice->addFilter('where', 'published', '1');
				$lanservice->addFilter('whereRaw', 'end < Now()');
				$currentlan = $lanservice->all()->sortByDesc(function($lan){return $lan->end;})->first();
				if ($currentlan==null) {
					return;
				}
			}
		}

		if ($lifetime) {

			//we have now awarded a new lan attendance. Recalculate count of lans
			$lanservice = new LanService;
			$lans = $lanservice->all();
			$attended = 0;
			foreach ($lans as $lan) {
				if (substr($lan->name,0,8) === "Insomnia") {
					if ($lan->achievement_id != null) {
						if (count($this->userAchievements()->where('lan_id',$lan->id)->where('achievement_id',$lan->achievement_id)->first()) == 1) {
							$attended++;
						}
					}
				}
			}
			//is the user linked to mpukman
			$mpukuser = $this->OAuths('MPUK')->first();
			if ($mpukuser!=null) {
				$mpukservice = new \Zeropingheroes\Lanager\Domain\MPUK\MPUKUserService;
				$mpukservice->addFilter('where','id',$mpukuser->service_id);
				$result = $mpukservice->all()->first();
				if ($result != null) {
					$attended = $attended + $result->total;
				}
			}
			//now check all 3 loyalty levels
			if ($attended > 5) {
				$silver_aid = Config::get('lanager/achievements.5InsomniaEvents',null);
				if ($silver_aid != null) {
					if (count($this->userAchievements()->where('achievement_id',$silver_aid)->first()) == 0){
						//user does not have achievement
						$achievement = new \Zeropingheroes\Lanager\Domain\UserAchievements\UserAchievement;
						$achievement->achievement_id = $silver_aid;
						$achievement->lan_id = $currentlan->id;
						$achievement->user_id = $this->id;
						$achievement->save();
					}
				}
			}
			if ($attended > 10) {
				$gold_aid = Config::get('lanager/achievements.10InsomniaEvents',null);
				if ($gold_aid != null) {
					if (count($this->userAchievements()->where('achievement_id',$gold_aid)->first()) == 0){
						//user does not have achievement
						$achievement = new \Zeropingheroes\Lanager\Domain\UserAchievements\UserAchievement;
						$achievement->achievement_id = $gold_aid;
						$achievement->lan_id = $currentlan->id;
						$achievement->user_id = $this->id;
						$achievement->save();
					}
				}

			}

			if ($attended > 20) {

				$ruby_aid = Config::get('lanager/achievements.20InsomniaEvents',null);
				if ($gold_aid != null) {
					if (count($this->userAchievements()->where('achievement_id',$ruby_aid)->first()) == 0){
						//user does not have achievement
						$achievement = new \Zeropingheroes\Lanager\Domain\UserAchievements\UserAchievement;
						$achievement->achievement_id = $ruby_aid;
						$achievement->lan_id = $currentlan->id;
						$achievement->user_id = $this->id;
						$achievement->save();
					}
				}
			}
								
		}
		//Discord linked
		$discord_achievement_id = Config::get('lanager/achievements.Discord',null);
		if ($discord_achievement_id != null) {
			if (count($this->userAchievements()->where('achievement_id',$discord_achievement_id)->first()) == 0){
				//user does not have achievement
				$discordAuth = $this->OAuths('Discord')->first();
				if ($discordAuth != null) {
					//discord is authd
					$achievement = new \Zeropingheroes\Lanager\Domain\UserAchievements\UserAchievement;
					$achievement->achievement_id = $discord_achievement_id;
					$achievement->lan_id = $currentlan->id;
					$achievement->user_id = $this->id;
					$achievement->save();
				}
			}
		}
		$bnet_achievement_id = Config::get('lanager/achievements.Battle.net',null);
		if ($bnet_achievement_id != null) {
			if (count($this->userAchievements()->where('achievement_id',$bnet_achievement_id)->first()) == 0){
				//user does not have achievement
				$bnetAuth = $this->OAuths('Battle.net')->first();
				if ($bnetAuth != null) {
					// Battle.net is authd
					$achievement = new \Zeropingheroes\Lanager\Domain\UserAchievements\UserAchievement;
					$achievement->achievement_id = $bnet_achievement_id;
					$achievement->lan_id = $currentlan->id;
					$achievement->user_id = $this->id;
					$achievement->save();
				}
			}
		}
		$earlyAccess_aid = Config::get('lanager/achievements.EarlyAccess',null);
		if ($earlyAccess_aid != null) {
			if (time() < 1492167600) {
				if (count($this->userAchievements()->where('achievement_id',$earlyAccess_aid)->first()) == 0){
					$achievement = new \Zeropingheroes\Lanager\Domain\UserAchievements\UserAchievement;
					$achievement->achievement_id = $earlyAccess_aid;
					$achievement->lan_id = $currentlan->id;
					$achievement->user_id = $this->id;
					$achievement->save();
				}
			}
		}

	}

}
