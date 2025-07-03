<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    /**
     * Display the about us page
     */
    public function index()
    {
        return view('frontend.about.index');
    }
} 