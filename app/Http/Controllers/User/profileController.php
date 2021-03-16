<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Firebase\JWT\JWT;
class profileController extends Controller
{
    function getProfile(){
        return response()->json(auth()->user());
     }
   }

