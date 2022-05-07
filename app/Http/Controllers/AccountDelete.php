<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Jetstream\DeleteUser;

class AccountDelete extends Controller {
	public function __invoke(Request $request) {
		if (!$request->hasValidSignature()) {
			abort(401);
		} else {
			$ctl = new DeleteUser;
			$ctl->delete($request->user());
			return redirect('/');
		}
		return null;
	}
}