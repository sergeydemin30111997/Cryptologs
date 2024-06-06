<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\AbstractController as HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbstractController extends HomeController
{
    public function __construct()
    {
        parent::__construct();

    }
}
