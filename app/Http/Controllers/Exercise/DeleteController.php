<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/08/11
 * Time: 17:14
 */

namespace App\Http\Controllers\Exercise;

use App\Usecase\AnswerHistoryUsecase;
use App\Usecase\ExerciseUsecase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ExerciseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


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

    public function complete($uuid)
    {
        $this->exerciseUsecase->deleteExercise($uuid);
        return view('exercise_delete_complete');
    }
}
