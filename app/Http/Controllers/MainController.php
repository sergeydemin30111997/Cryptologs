<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends AbstractController
{
    public function faq() {
        return view('faq');
    }
}
