<?php

namespace App\Http\Controllers;

use App\Usecase\AnswerHistoryUsecase;
use App\Usecase\ExerciseUsecase;
use Illuminate\Http\Request;
use App\Http\Requests\ExerciseRequest;
use Illuminate\Support\Facades\Auth;

class ExerciseController extends Controller
{
    protected $exerciseUsecase;

    protected $answerHistoryUsecase;

    /**
     * Create a new controller instance.
     *
     * @param ExerciseUsecase $exerciseUsecase
     * @param AnswerHistoryUsecase $answerHistoryUsecase
     */
    public function __construct(ExerciseUsecase $exerciseUsecase, AnswerHistoryUsecase $answerHistoryUsecase)
    {
        $this->middleware('auth');
        $this->exerciseUsecase = $exerciseUsecase;
        $this->answerHistoryUsecase = $answerHistoryUsecase;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $exercise_list = $this->exerciseUsecase->getAllExercises(10);
        if (Auth::check()) {
            $exercise_history_list = $this->answerHistoryUsecase->getExerciseHistoryCountByExerciseList(Auth::user(), $exercise_list);
            return view('exercise_index')
                ->with('exercise_list', $exercise_list)
                ->with('exercise_history_list', $exercise_history_list)
                ->with('user_id', Auth::id());
        } else {
            return view('exercise_index')
                ->with('exercise_list', $exercise_list);
        }
    }

    public function list()
    {
        return view('exercise_list');
    }

}
