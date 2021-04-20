<?php

namespace App\Http\Controllers;

use App\Constant;
use App\Usecase\ExerciseUsecase;
use Illuminate\Support\Facades\Auth;

class ExerciseController extends Controller
{
    protected $exerciseUsecase;

    /**
     * Create a new controller instance.
     *
     * @param ExerciseUsecase $exerciseUsecase
     */
    public function __construct(ExerciseUsecase $exerciseUsecase)
    {
        $this->exerciseUsecase = $exerciseUsecase;
    }

    public function list()
    {
        if (Auth::check()) {
            $exercise_list = $this->exerciseUsecase->getAllExercises(
                Constant::INIT_EXERCISE_LOAD_NUMBER,
                Auth::user()
            );
            $count = $this->exerciseUsecase->getExerciseCount(Auth::user());
            return view('exercise_index')
                ->with('exercise_list', $exercise_list)
                ->with('user_id', Auth::id())
                ->with('count', $count);
        } else {
            $exercise_list = $this->exerciseUsecase->getAllExercises(Constant::INIT_EXERCISE_LOAD_NUMBER);
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
