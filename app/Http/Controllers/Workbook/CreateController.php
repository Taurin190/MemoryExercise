<?php

namespace App\Http\Controllers\Workbook;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkbookFormRequest;
use App\Http\Requests\WorkbookRequest;
use App\Usecase\ExerciseUsecase;
use App\Usecase\WorkbookUsecase;
use Illuminate\Support\Facades\Auth;

class CreateController extends Controller
{
    protected $workbook_usecase;

    protected $exercise_usecase;

    public function __construct(WorkbookUsecase $workbook_usecase, ExerciseUsecase $exercise_usecase)
    {
        $this->middleware('auth');
        $this->workbook_usecase = $workbook_usecase;
        $this->exercise_usecase = $exercise_usecase;
    }

    public function create(WorkbookRequest $request)
    {
        $workbook_dto = $request->convertDtoBySession(Auth::id(), '_create');
        return view('workbook_create')
            ->with('workbook', $workbook_dto);
    }

    public function confirm(WorkbookFormRequest $request)
    {
        $exercise_id_list = $request->get('exercise', []);
        $request_workbook_dto = $request->convertDtoByRequest(Auth::id());
        $workbook_dto = $this->workbook_usecase->getWorkbookWithExerciseIdList(
            $request_workbook_dto,
            $exercise_id_list,
            Auth::user()
        );

        $request->storeSessions($workbook_dto, '_create');
        $request->session()->put('exercise_id_list_create', $exercise_id_list);
        return view('workbook_confirm')
            ->with('workbook', $workbook_dto)
            ->with('exercise_list', $workbook_dto->exercise_list);
    }

    public function complete(WorkbookRequest $request)
    {
        $workbook_dto = $request->convertDtoBySession(Auth::id(), '_create');
        $this->workbook_usecase->registerWorkbook($workbook_dto, Auth::user());
        return view('workbook_complete');
    }
}
