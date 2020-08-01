<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/05/03
 * Time: 7:15
 */

namespace App\Http\Controllers;
use App\Usecase\AnswerHistoryUsecase;
use App\Usecase\WorkbookUsecase;
use App\Usecase\ExerciseUsecase;
use App\Domain\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkbookController extends Controller
{
    protected $workbook_usecase;

    protected $exercise_usecase;

    protected $history_usecase;

    public function __construct(WorkbookUsecase $workbook_usecase, ExerciseUsecase $exercise_usecase, AnswerHistoryUsecase $history_usecase) {
        $this->workbook_usecase = $workbook_usecase;
        $this->exercise_usecase = $exercise_usecase;
        $this->history_usecase = $history_usecase;
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
        if (Auth::check()) {
            $this->history_usecase->addAnswerHistory($answer, $workbook, Auth::user());
        }

        return view('workbook_result')
            ->with('workbook', $workbook)
            ->with('answer', $answer)
            ->with('answer_graph_data', $answer->toGraphData())
            ->with('exercise_count', $answer->getExerciseCount());
    }
}
