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

    public function edit($uuid)
    {
        $exercise = $this->exerciseUsecase->getExercises($uuid, Auth::user());
        return view('exercise_edit')
            ->with('exercise', $exercise);
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
        $label_list = $request->get('label');
        $permission = $request->get('permission');
        $exercise = $this->exerciseUsecase->makeExercise($question, $answer, $permission);
        $request->session()->put('question', $request->get('question'));
        $request->session()->put('answer', $request->get('answer'));
        return view('exercise_confirm')
            ->with("exercise", $exercise);
    }

    public function complete(ExerciseRequest $request)
    {
        $question = $request->get('question');
        $answer = $request->get('answer');
        $permission = $request->get('permission');
        $this->exerciseUsecase->createExercise($question, $answer, $permission);
        $request->session()->forget('question');
        $request->session()->forget('answer');
        return view('exercise_complete');
    }
}