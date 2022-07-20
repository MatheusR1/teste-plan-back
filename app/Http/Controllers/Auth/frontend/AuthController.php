<?php

namespace App\Http\Controllers\Auth\frontend;
use App\Http\Controllers\Controller;


class AuthController extends Controller{

    public function __invoke()
    {
        return auth()->user();
    }
}