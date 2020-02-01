<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExerciseController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('exercise_index');
    }

    public function list()
    {
        return view('exercise_list');
    }

    public function create()
    {
        return view('exercise_create');
    }

    public function form()
    {
        return view('exercise_form');
    }
}
