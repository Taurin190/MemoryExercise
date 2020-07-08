<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/05/03
 * Time: 7:15
 */

namespace App\Http\Controllers;
use App\Usecase\WorkbookUsecase;
use App\Usecase\ExerciseUsecase;
use App\Domain\Answer;
use Illuminate\Http\Request;
use App\Http\Requests\WorkbookRequest;

class WorkbookController extends Controller
{
    protected $workbook_usecase;

    protected $exercise_usecase;

    public function __construct(WorkbookUsecase $workbook_usecase, ExerciseUsecase $exercise_usecase) {
        $this->workbook_usecase = $workbook_usecase;
        $this->exercise_usecase = $exercise_usecase;
    }
    public function list()
    {
        $workbook_list = $this->workbook_usecase->getAllWorkbook();

        return view("workbook_list")
            ->with('workbooks', $workbook_list);
    }
    public function detail($uuid)
    {
        $workbook = $this->workbook_usecase->getWorkbook($uuid);
        return view('workbook_detail')
            ->with('workbook', $workbook)
            ->with('workbook_array', $workbook->toArray());
    }
    public function result($uuid, Request $request)
    {
        $workbook = $this->workbook_usecase->getWorkbook($uuid);
        $answer = new Answer($request);
        return view('workbook_result')
            ->with('workbook', $workbook)
            ->with('answer', $answer)
            ->with('answer_graph_data', $answer->toGraphData())
            ->with('exercise_count', $answer->getExerciseCount());
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
