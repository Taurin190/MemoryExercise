<?php

namespace App\Http\Controllers\Exercise;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExerciseFormRequest;
use App\Usecase\ExerciseUsecase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class EditController extends Controller
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

    public function edit($uuid, Request $request)
    {
        $exercise_dto = $this->exerciseUsecase->getExerciseDtoByIdWithSessionModification($uuid, Auth::id(), $request, '_edit');
        return view('exercise_edit')
            ->with('exercise', $exercise_dto);
    }

    /**
     * when post from form
     * @param $uuid
     * @param ExerciseFormRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Domain\DomainException
     * @throws \App\Exceptions\DataNotFoundException
     * @throws \App\Exceptions\PermissionException
     */
    public function confirm($uuid, ExerciseFormRequest $request)
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
