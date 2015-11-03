<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

class PasswordVerifier extends Controller
{
    public function verify($username, $password)
    {
    	$credentials =
    	[
        	'email'    => $username,
        	'password' => $password,
      	];

      	if(Auth::once($credentials))
      	{
        	return Auth::user()->id;
      	}

      	return false;
    }
}
