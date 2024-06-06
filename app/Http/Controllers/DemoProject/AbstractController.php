<?php

namespace App\Http\Controllers\DemoProject;

use App\Http\Controllers\AbstractController as HomeController;
use Illuminate\Http\Request;

abstract class AbstractController extends HomeController
{
    public function __construct()
    {
        parent::__construct();

    }
}
