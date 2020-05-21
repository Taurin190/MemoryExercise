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

    public function create(Request $request)
    {
        $question = $request->session()->pull('question', '');
        $answer = $request->session()->pull('answer', '');
        return view('exercise_create')
            ->with('question', $question)
            ->with('answer', $answer);
    }

    /**
     * when post from form
     * @param ExerciseRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirm(ExerciseRequest $request)
    {
        $exercise = $this->exerciseUsecase->getExerciseDomainFromRequest($request);
        $request->session()->put('question', $request->get('question'));
        $request->session()->put('answer', $request->get('answer'));
        return view('exercise_confirm')
            ->with("exercise", $exercise);
    }

    public function complete(ExerciseRequest $request)
    {
        $this->exerciseUsecase->createExerciseFromRequest($request);
        $request->session()->flush();
        return view('exercise_complete');
    }

}
