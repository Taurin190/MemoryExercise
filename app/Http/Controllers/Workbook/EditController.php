<?php

namespace App\Http\Controllers\Workbook;


use App\Http\Controllers\Controller;
use App\Http\Requests\WorkbookFormRequest;
use App\Http\Requests\WorkbookRequest;
use App\Usecase\ExerciseUsecase;
use App\Usecase\WorkbookUsecase;
use Illuminate\Support\Facades\Auth;

class EditController extends Controller
{
    protected $workbook_usecase;

    protected $exercise_usecase;

    public function __construct(WorkbookUsecase $workbook_usecase, ExerciseUsecase $exercise_usecase)
    {
        $this->middleware('auth');
        $this->workbook_usecase = $workbook_usecase;
        $this->exercise_usecase = $exercise_usecase;
    }

    public function edit($uuid, WorkbookRequest $request)
    {
        $session_workbook_dto = $request->convertDtoBySession(Auth::id(), '_edit', $uuid);
        $workbook_dto = $this->workbook_usecase->getMergedWorkbook($uuid, Auth::id(), $session_workbook_dto);
        return view('workbook_edit')
            ->with('workbook', $workbook_dto);
    }

    public function confirm($uuid, WorkbookFormRequest $request)
    {
        $request_workbook_dto = $request->convertDtoByRequest(Auth::id(), $uuid);
        $exercise_id_list = $request->get('exercise', []);
        $workbook_dto = $this->workbook_usecase->getMergedWorkbook($uuid, Auth::id(), $request_workbook_dto, $exercise_id_list);
        $request->storeSessions($workbook_dto);

        return view('workbook_edit_confirm')
            ->with('workbook', $workbook_dto)
            ->with('exercise_list', $workbook_dto->exercise_list);
    }

    public function complete($uuid, WorkbookRequest $request)
    {
        $title = $request->get('title');
        $explanation = $request->get('explanation');
        $exercise_id_list = $request->get('exercise');
        $exercise_list = null;
        if (isset($exercise_id_list)) {
            $exercise_list = $this->exercise_usecase->getAllExercisesWithIdList($exercise_id_list);
        }
        $this->workbook_usecase->modifyWorkbook($uuid, $title, $explanation, $exercise_list);

        return view('workbook_edit_complete');
    }
}
