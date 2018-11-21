<?php

namespace App\Http\Controllers;

use App\User; 
use App\Http\Requests;
use App\Mailers\AppMailer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegistrationController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function postRegister(Request $request, AppMailer $mailer)
    {
        // validate the request

        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required'
        ]);

        // create the user

        $user = User::create($request->all());

        // email them a confirmation link

        $mailer->sendEmailConfirmationTo($user);

        // flash message

        flash('Please confirm your email address.');
         
        // redirect back
            
        return redirect()->back();
    }
}
 