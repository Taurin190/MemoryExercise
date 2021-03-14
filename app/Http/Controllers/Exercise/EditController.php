<?php

namespace App\Http\Controllers\Exercise;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExerciseFormRequest;
use App\Http\Requests\ExerciseRequest;
use App\Usecase\ExerciseUsecase;
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

    public function edit($uuid, ExerciseRequest $request)
    {
        $session_exercise_dto = $request->convertDtoBySession(Auth::id(), '_edit', $uuid);
        $exercise_dto = $this->exerciseUsecase->getMergedExercise($uuid, Auth::id(), $session_exercise_dto);
        return view('exercise_edit')
            ->with('exercise', $exercise_dto);
    }

    /**
     * when post from form
     * @param $uuid
     * @param ExerciseFormRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\PermissionException
     */
    public function confirm($uuid, ExerciseFormRequest $request)
    {
        $request_exercise_dto = $request->convertDtoByRequest(Auth::id(), $uuid);
        $exercise_dto = $this->exerciseUsecase->getMergedExercise($uuid, Auth::id(), $request_exercise_dto);
        $request->storeSessions($exercise_dto, '_edit');
        return view('exercise_edit_confirm')
            ->with("exercise", $exercise_dto);
    }

    /**
     * @param $uuid
     * @param ExerciseRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\DataNotFoundException
     * @throws \App\Exceptions\PermissionException
     */
    public function complete($uuid, ExerciseRequest $request)
    {
        $session_exercise_dto = $request->convertDtoBySession(Auth::id(), '_edit', $uuid);
        $this->exerciseUsecase->editExercise($uuid, Auth::id(), $session_exercise_dto);
        return view('exercise_edit_complete');
    }
}
