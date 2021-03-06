<?php

namespace App\Http\Controllers;

use App\destroy_subscribe;
use App\feedback;
use App\Http\Requests\NewSellRequest;
use App\mailData;
use App\sell;
use App\User;

class homeController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('/home');
	}

	public function buy_from_college() {
		if (!auth()->check()) {
			return redirect()->home();
		}
		$sells_with_CN = auth()->user()->college_wise_sells();
		return view('buy.college', compact('sells_with_CN'));
	}

	public function buy_from_university() {
		if (!auth()->check()) {
			return redirect()->home();
		}
		$sells_with_UN = auth()->user()->university_wise_sells();
		return view('buy.university', compact('sells_with_UN'));
	}

	public function buy_from_state() {
		if (!auth()->check()) {
			return redirect()->home();
		}
		$sells_with_SN = auth()->user()->state_wise_sells();
		return view('buy.state', compact('sells_with_SN'));
	}

	public function buy() {
		if (!auth()->check()) {
			return redirect()->home();
		}
		$sells_with_CN = auth()->user()->college_wise_sells();
		$sells_with_UN = auth()->user()->university_wise_sells();
		// $sells_with_SN = auth()->user()->state_wise_sells();
		return view('buy.buy', compact('sells_with_CN', 'sells_with_UN'));
	}

	public function all() {
		if (!auth()->check()) {
			return redirect()->home();
		}
		$all_sells = sell::paginate(10);
		return view('buy.all', compact('all_sells'));
	}

	public function sell() {
		if (!auth()->check()) {
			return redirect()->home();
		}
		return view('sell');
	}

	public function store(NewSellRequest $request) {
		$request->persist();
		\Session::flash('sell_message', 'your Item added successfully.');
		return redirect()->back();
	}

	public function show(sell $buy) {
		return view('show', compact('buy'));
	}

	public function about() {
		return view('about');
	}

	public function category() {
		$sells_with_category = sell::category_wise_sell(request()->degree_name);
		return view('buy.category', compact('sells_with_category'));
	}

	public function contactData(sell $id) {
		$this->validate(request(), [
			'contact_no' => 'required|regex:^(\+91[\-\s]?)?[0]?(91)?[789]\d{9}$^',
		], [
			'contact_no.required' => 'provide your contact number',
			'contact_no.regex' => 'Invalide contact number',
		]);

		mailData::contact($id);
		\Session::flash('flash_message', 'your message sent successfully.');
		return redirect()->back();
	}

	public function message(sell $id) {
		$this->validate(request(), [
			'message' => 'required|max:500',
		]);

		mailData::message($id);
		\Session::flash('flash_message', 'your message sent successfully.');
		return redirect()->back();
	}

	public function feedback() {
		if (\Auth::check()) {
			feedback::create([
				'email' => auth()->user()->email,
				'message' => request()->message,
			]);
		} else {
			feedback::create([
				'email' => request()->email,
				'message' => request()->message,
			]);
		}

		\Session::flash('feedback_message', 'your feedback sent successfully.');
		return redirect()->back();
	}

	public function pagenotfound() {
		return view('errors.503');
	}

	public function unsubscribe() {
		return view('unsubscribe');
	}

	public function destroy_subscribe() {
		$destroy_user = User::where('email', request()->email)->first();
		if (!count($destroy_user) > 0) {
			dd("Your Email Does not Exist");
		}
		// dd($destroy_user->name);
		$unsubscribe = new destroy_subscribe;
		$unsubscribe->name = $destroy_user->name;
		$unsubscribe->email = $destroy_user->email;
		$unsubscribe->password = $destroy_user->password;
		$unsubscribe->college_name = $destroy_user->college_name;
		$unsubscribe->remember_token = $destroy_user->remember_token;
		$unsubscribe->save();
		return view('destroy_subscribe');
	}

	public function sold($id) {
		$sell = sell::find($id);
		$sell->update([
			'sold_out' => 1,
		]);
		return redirect()->home();
	}

}
