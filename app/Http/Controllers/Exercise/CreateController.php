<?php

namespace App\Http\Controllers\Exercise;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExerciseFormRequest;
use App\Http\Requests\ExerciseRequest;
use App\Usecase\ExerciseUsecase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CreateController extends Controller
{
    protected $exerciseUsecase;

    /**
     * Create a new controller instance.
     *
     * @param ExerciseUsecase $exerciseUsecase
     */
    public function __construct(ExerciseUsecase $exerciseUsecase)
    {
        $this->middleware('auth');
        $this->exerciseUsecase = $exerciseUsecase;
    }

    public function create(ExerciseRequest $request)
    {
        $exercise_dto = $request->convertDtoBySession(Auth::id(), '_create');
        return view('exercise_create')
            ->with('exercise', $exercise_dto);
    }

    /**
     * when post from form
     * @param ExerciseFormRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Domain\DomainException
     */
    public function confirm(ExerciseFormRequest $request)
    {
        $exercise_dto = $this->exerciseUsecase->getExerciseDtoByRequest($request, Auth::id());
        $request->session()->put('question_create', $exercise_dto->question);
        $request->session()->put('answer_create', $exercise_dto->answer);
        $request->session()->put('permission_create', $exercise_dto->permission);
        $request->session()->put('label_create', $exercise_dto->label_list);
        return view('exercise_confirm')
            ->with("exercise", $exercise_dto);
    }

    public function complete(ExerciseRequest $request)
    {
        $this->exerciseUsecase->registerExercise($request->convertDtoBySession(Auth::id(), '_create'));
        return view('exercise_complete');
    }
}
