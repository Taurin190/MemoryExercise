<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/08/11
 * Time: 17:14
 */

namespace App\Http\Controllers\Exercise;

use App\Dto\ExerciseDto;
use App\Usecase\AnswerHistoryUsecase;
use App\Usecase\ExerciseUsecase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ExerciseRequest;
use Illuminate\Support\Facades\Auth;


class CreateController extends Controller
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

    public function create(Request $request)
    {
        $exercise_dto = $this->exerciseUsecase->getExerciseDtoBySession($request, Auth::id(), '_create');
        return view('exercise_create')
            ->with('exercise', $exercise_dto);
    }

    /**
     * when post from form
     * @param ExerciseRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirm(ExerciseRequest $request)
    {
        $exercise_dto = $this->exerciseUsecase->getExerciseDtoByRequest($request, Auth::id());
        $request->session()->put('question_create', $exercise_dto->question);
        $request->session()->put('answer_create', $exercise_dto->answer);
        $request->session()->put('permission_create', $exercise_dto->permission);
        $request->session()->put('label_create', $exercise_dto->label_list);
        return view('exercise_confirm')
            ->with("exercise", $exercise_dto);
    }

    public function complete(Request $request)
    {
        $this->exerciseUsecase->registerExerciseByRequest($request, Auth::id());
        $request->session()->forget('question_create');
        $request->session()->forget('answer_create');
        return view('exercise_complete');
    }
}
