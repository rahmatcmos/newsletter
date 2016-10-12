<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $about = \Markdown::convertToHtml(\File::get('../README.md'));

        return view('home', compact('about'));
    }

    public function getAbout()
    {
        return view('about');
    }
}
