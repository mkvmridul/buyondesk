<?php

namespace App;
use App\category;
use App\datas;
use App\sell;
use App\User;
use Illuminate\Database\Eloquent\Model;

class sell extends Model {
	protected $guarded = ['id'];

	public function user() {
		return $this->belongsTo(User::class);
	}

	public function getTitleAttribute($value) {
		return ucFirst($value);
	}

	public function getAuthorAttribute($value) {
		return ucFirst($value);
	}

	public static function SellerCollegeName($sell) {
		$college_name = strstr($sell->user->college_name, '(', true); //strstr() -> first occurence of a string inside a string
		return preg_replace('/[0-9]+/', '', $college_name);
	}

	public function SellerUniversityName($sell) {
		return substr(strstr(datas::where('college_name', $sell->user->college_name)->pluck('university_name'), '(', true), 2);
	}

	public function RouteParameter($sell) {
		return view('home');
	}

	public static function category_wise_sell($degree_key) {
		$degree_name = category::all()->where('degree_key', $degree_key)->pluck('degree_name');
		$sells_with_category = [];
		foreach ($degree_name as $key => $value) {
			$sells_with_category[] = sell::all()->where('degree_name', $value);
		}
		return $sells_with_category;
	}
}
