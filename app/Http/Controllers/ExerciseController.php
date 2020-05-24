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
        $question = $request->get('question');
        $answer = $request->get('answer');
        $exercise = $this->exerciseUsecase->makeExercise($question, $answer);
        $request->session()->put('question', $request->get('question'));
        $request->session()->put('answer', $request->get('answer'));
        return view('exercise_confirm')
            ->with("exercise", $exercise);
    }

    public function complete(ExerciseRequest $request)
    {
        $question = $request->get('question');
        $answer = $request->get('answer');
        $this->exerciseUsecase->createExercise($question, $answer);
        $request->session()->forget('question');
        $request->session()->forget('answer');
        return view('exercise_complete');
    }

}
