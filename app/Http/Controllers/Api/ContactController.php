<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function sendContactMail(Request $request)
    {
        $content = $request->contact;
        //$email = <送信先アドレス>;
	
	    Mail::to($email)->send(new ContactMail($content));
	}
}
