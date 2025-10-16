<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function about()
    {
        return view('frontend.about'); // trả về file about.blade.php
    }
}
