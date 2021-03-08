<?php

namespace App\Http\Controllers\Exercise;

use App\Http\Controllers\Controller;
use App\Usecase\AnswerHistoryUsecase;
use App\Usecase\ExerciseUsecase;
use Illuminate\Support\Facades\Auth;


class DeleteController extends Controller
{
    protected $exerciseUsecase;

    protected $answerHistoryUsecase;

    /**
     * Create a new controller instance.
     *
     * @param ExerciseUsecase $exerciseUsecase
     * @param AnswerHistoryUsecase $answerHistoryUsecase
     */
    public function __construct(ExerciseUsecase $exerciseUsecase)
    {
        $this->middleware('auth');
        $this->exerciseUsecase = $exerciseUsecase;
    }

    /**
     * @param $uuid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception 編集権限がない場合は例外を出す
     */
    public function complete($uuid)
    {
        $this->exerciseUsecase->deleteExercise($uuid, Auth::id());
        return view('exercise_delete_complete');
    }
}
