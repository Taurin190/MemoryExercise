<?php

namespace App\Http\Controllers;

use App\Usecase\ExerciseUsecase;
use Illuminate\Http\Request;
use App\Http\Requests\ExerciseRequest;

class ExerciseController extends Controller
{
    protected $exerciseUsecase;

    /**
     * Create a new controller instance.
     *
     * @param ExerciseUsecase $usecase
     */
    public function __construct(ExerciseUsecase $usecase)
    {
        $this->middleware('auth');
        $this->exerciseUsecase = $usecase;
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
        return view('exercise_form');
    }

    /**
     * when post from form
     * @param ExerciseRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirm(ExerciseRequest $request)
    {
        $this->exerciseUsecase->createExerciseFromRequest($request);
        return view('exercise_list');
    }

}
