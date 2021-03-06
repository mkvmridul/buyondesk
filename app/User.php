<?php

namespace App;

use App\datas;
use App\Mail\WelcomeMail;
use App\sell;
use App\User;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Mail;
use Request;

class User extends Authenticatable {
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'college_name',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public static function register() {

		$user = User::create([
			'name' => request('name'),
			'email' => request('email'),
			'password' => bcrypt(request('password')),
			'college_name' => request('college_name'),
		]);

		auth()->login($user);

		Mail::to($user)->send(new WelcomeMail($user))->subject('Welcome to buyondesk.com');
	}

	public function sells() {
		return $this->hasMany(sell::class);
	}

	public function college_wise_sells() {
		$userCN = auth()->user()->college_name;
		$allUsers = $this::all()->where('college_name', $userCN);
		$sells = [];
		foreach ($allUsers as $key => $value) {
			$usersID = $value['id'];
			if (count(sell::all()->where('user_id', $usersID)) > 0) {
				$sells[] = sell::all()->where('user_id', $usersID);
			}
		}
		return $sells;
	}

	public function university_wise_sells() {
		$userCN = auth()->user()->college_name;
		$userUN = datas::where('college_name', $userCN)->pluck('university_name');
		$allCN = datas::where('university_name', $userUN)->pluck('college_name');
		$sells = [];
		foreach ($allCN as $key => $value) {
			$allUsers = $this::all()->where('college_name', $value);
			foreach ($allUsers as $key => $value) {
				$usersID = $value['id'];
				if (count(sell::all()->where('user_id', $usersID)) > 0) {
					$sells[] = sell::all()->where('user_id', $usersID);
				}
			}
		}
		return $sells;

	}

	/***********too slow********/
/*
public function state_wise_sells() {
$userCN = auth()->user()->college_name;
$userSN = datas::where('college_name', $userCN)->pluck('state_name');
$allCN = datas::where('state_name', $userSN)->pluck('college_name');
$sells = [];
foreach ($allCN as $key => $value) {
$allUsers = $this::all()->where('college_name', $value);
foreach ($allUsers as $key => $value) {
$usersID = $value['id'];
if (count(sell::all()->where('user_id', $usersID)) > 0) {
$sells[] = sell::all()->where('user_id', $usersID);
}
}
}
return $sells;
}
 */

	public function getCollegeName($sellerUserId) {
		$college_name = auth()->user()::all()->where('id', $sellerUserId)->pluck('college_name');
		$college_name = substr(strstr($college_name, '(', true), 2);
		return preg_replace('/[0-9]+/', '', $college_name);
	}

	public function getUniversityName($sellerUserId) {
		$college_name = auth()->user()::all()->where('id', $sellerUserId)->pluck('college_name');
		$university_name = datas::where('college_name', $college_name)->pluck('university_name');
		$university_name = substr(strstr($university_name, '(', true), 2);
		return preg_replace('/[0-9]+/', '', $university_name);
	}

	public function getStateName($sellerUserId) {
		$college_name = auth()->user()::all()->where('id', $sellerUserId)->pluck('college_name');
		$state_name = datas::where('college_name', $college_name)->pluck('state_name');
		$state_name = preg_replace('/[^a-zA-Z0-9\']/', '', $state_name);
		return $state_name;
	}

	public function userInterests() {
		return null;
	}

}
