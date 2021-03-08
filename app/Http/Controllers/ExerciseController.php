<?php

namespace App\Http\Controllers;

use App\Usecase\AnswerHistoryUsecase;
use App\Usecase\ExerciseUsecase;
use Illuminate\Http\Request;
use App\Http\Requests\ExerciseFormRequest;
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
        if (Auth::check()) {
            $exercise_list = $this->exerciseUsecase->getAllExercises(12, Auth::user());
            $count = $this->exerciseUsecase->getExerciseCount(Auth::user());
            $exercise_history_list = $this->answerHistoryUsecase->getExerciseHistoryCountByExerciseList(Auth::user(), $exercise_list);
            return view('exercise_index')
                ->with('exercise_list', $exercise_list)
                ->with('exercise_history_list', $exercise_history_list)
                ->with('user_id', Auth::id())
                ->with('count', $count);
        } else {
            $exercise_list = $this->exerciseUsecase->getAllExercises(12);
            $count = $this->exerciseUsecase->getExerciseCount();
            return view('exercise_index')
                ->with('exercise_list', $exercise_list)
                ->with('count', $count);
        }
    }

    public function list()
    {
        if (Auth::check()) {
            $exercise_list = $this->exerciseUsecase->getAllExercises(12, Auth::user());
            $count = $this->exerciseUsecase->getExerciseCount(Auth::user());
            $exercise_history_list = $this->answerHistoryUsecase->getExerciseHistoryCountByExerciseList(Auth::user(), $exercise_list);
            return view('exercise_index')
                ->with('exercise_list', $exercise_list)
                ->with('exercise_history_list', $exercise_history_list)
                ->with('user_id', Auth::id())
                ->with('count', $count);
        } else {
            $exercise_list = $this->exerciseUsecase->getAllExercises(12);
            $count = $this->exerciseUsecase->getExerciseCount();
            return view('exercise_index')
                ->with('exercise_list', $exercise_list)
                ->with('count', $count);
        }
    }

    public function detail($uuid)
    {
        $exercise_dto = $this->exerciseUsecase->getExerciseDtoById($uuid, Auth::id());
        return view('exercise_detail')
            ->with('exercise', $exercise_dto)
            ->with('user_id', Auth::id());
    }

}
