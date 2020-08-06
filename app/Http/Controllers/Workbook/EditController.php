<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/08/06
 * Time: 22:32
 */

namespace App\Http\Controllers\Workbook;


use App\Http\Controllers\Controller;
use App\Http\Requests\WorkbookRequest;
use App\Usecase\ExerciseUsecase;
use App\Usecase\WorkbookUsecase;

class EditController extends Controller
{
    protected $workbook_usecase;

    protected $exercise_usecase;

    public function __construct(WorkbookUsecase $workbook_usecase, ExerciseUsecase $exercise_usecase) {
        $this->middleware('auth');
        $this->workbook_usecase = $workbook_usecase;
        $this->exercise_usecase = $exercise_usecase;
    }

    public function edit($uuid)
    {
        return view('workbook_create');
    }

    public function confirm($uuid, WorkbookRequest $request)
    {
        $title = $request->get('title');
        $explanation = $request->get('explanation');
        $exercise_id_list = $request->get('exercise');
        if (isset($exercise_id_list)) {
            $exercise_list = $this->exercise_usecase->getAllExercisesWithIdList($exercise_id_list);
            $workbook = $this->workbook_usecase->makeWorkbook($title, $explanation);
            return view('workbook_confirm')
                ->with('workbook', $workbook)
                ->with('exercise_list', $exercise_list);
        } else {
            $workbook = $this->workbook_usecase->makeWorkbook($title, $explanation);
            return view('workbook_confirm')
                ->with('workbook', $workbook);
        }
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
        $this->workbook_usecase->createWorkbook($title, $explanation, $exercise_list);

        return view('workbook_complete');
    }
}
