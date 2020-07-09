<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/07/09
 * Time: 18:02
 */

namespace App\Http\Controllers;
use App\Usecase\WorkbookUsecase;
use App\Usecase\ExerciseUsecase;
use App\Http\Requests\WorkbookRequest;


class WorkbookManageController extends Controller
{
    protected $workbook_usecase;

    protected $exercise_usecase;

    public function __construct(WorkbookUsecase $workbook_usecase, ExerciseUsecase $exercise_usecase) {
        $this->middleware('auth');
        $this->workbook_usecase = $workbook_usecase;
        $this->exercise_usecase = $exercise_usecase;
    }

    public function create()
    {
        return view('workbook_create');
    }

    public function confirm(WorkbookRequest $request)
    {
        $title = $request->get('title');
        $explanation = $request->get('explanation');
        $exercise_id_list = $request->get('exercise');
        $exercise_list = $this->exercise_usecase->getAllExercisesWithIdList($exercise_id_list);
        $workbook = $this->workbook_usecase->makeWorkbook($title, $explanation);
        return view('workbook_confirm')
            ->with('workbook', $workbook)
            ->with('exercise_list', $exercise_list);
    }

    public function complete(WorkbookRequest $request)
    {
        $title = $request->get('title');
        $explanation = $request->get('explanation');
        $this->workbook_usecase->createWorkbook($title, $explanation);

        return view('workbook_complete');
    }
}
