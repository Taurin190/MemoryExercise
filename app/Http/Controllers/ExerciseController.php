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

    /**
     * when post from form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        if (Request::has('InputName')) {
            $name = Request::input('InputName');
        } else {

        }
        if (Request::has('InputQuestion')) {
            $question = Request::input('InputQuestion');
        } else {

        }
        if (Request::has('InputAnswer')) {
            $answer = Request::input('InputAnswer');
        } else {

        }
        return view('exercise_create');
    }

    public function form()
    {
        return view('exercise_form');
    }
}
