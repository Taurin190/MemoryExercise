<?php

namespace App\Http\Controllers\Exercise;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExerciseFormRequest;
use App\Http\Requests\ExerciseRequest;
use App\Usecase\ExerciseUsecase;
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
        $exercise_dto = $request->convertFromRequest(Auth::id());
        // ドメインで整合性が取れるか問い合わせる
        $this->exerciseUsecase->validate($exercise_dto, Auth::id());
        $request->storeSessions($exercise_dto, '_create');
        return view('exercise_confirm')
            ->with("exercise", $exercise_dto);
    }

    public function complete(ExerciseRequest $request)
    {
        $this->exerciseUsecase->registerExercise($request->convertDtoBySession(Auth::id(), '_create'));
        return view('exercise_complete');
    }
}
