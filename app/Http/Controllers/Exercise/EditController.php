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


class EditController extends Controller
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

    public function edit($uuid)
    {
        // Permissionがない場合Exceptionでエラーページを表示する
        $this->exerciseUsecase->checkEditPermission($uuid, Auth::id());
        $exercise_dto = $this->exerciseUsecase->getExerciseDtoById($uuid, Auth::id());
        return view('exercise_edit')
            ->with('exercise', $exercise_dto);
    }

    /**
     * when post from form
     * @param $uuid
     * @param ExerciseRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirm($uuid, ExerciseRequest $request)
    {
        $exercise_dto = $this->exerciseUsecase->getExerciseDtoByRequest($request, Auth::id(), $uuid);
        $request->session()->put('question', $request->get('question_edit'));
        $request->session()->put('answer', $request->get('answer_edit'));
        return view('exercise_edit_confirm')
            ->with("exercise", $exercise_dto);
    }

    public function complete($uuid, ExerciseRequest $request)
    {
        $this->exerciseUsecase->updateExerciseByRequest($request, Auth::id(), $uuid);
        $request->session()->forget('question_edit');
        $request->session()->forget('answer_edit');
        return view('exercise_edit_complete');
    }
}
