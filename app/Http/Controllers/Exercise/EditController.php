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

    public function edit($uuid, Request $request)
    {
        $exercise_dto = $this->exerciseUsecase->getExerciseDtoByIdWithSessionModification($uuid, Auth::id(), $request, '_edit');
        return view('exercise_edit')
            ->with('exercise', $exercise_dto);
    }

    /**
     * when post from form
     * @param $uuid
     * @param ExerciseRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Domain\DomainException
     * @throws \App\Exceptions\DataNotFoundException
     * @throws \App\Exceptions\PermissionException
     */
    public function confirm($uuid, ExerciseRequest $request)
    {
        $exercise_dto = $this->exerciseUsecase->getEditedExerciseDtoByRequest($uuid, $request, Auth::id());
        $request->session()->put('question_edit', $exercise_dto->question);
        $request->session()->put('answer_edit', $exercise_dto->answer);
        $request->session()->put('permission_edit', $exercise_dto->permission);
        $request->session()->put('label_edit', $exercise_dto->label_list);
        return view('exercise_edit_confirm')
            ->with("exercise", $exercise_dto);
    }

    public function complete($uuid, Request $request)
    {
        $this->exerciseUsecase->editExerciseByRequestSession($uuid, $request, Auth::id(), '_edit');
        return view('exercise_edit_complete');
    }
}
