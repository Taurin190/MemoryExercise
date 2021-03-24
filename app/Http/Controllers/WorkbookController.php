<?php

namespace App\Http\Controllers;

use App\Domain\Answer;
use App\Usecase\AnswerHistoryUsecase;
use App\Usecase\WorkbookUsecase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkbookController extends Controller
{
    protected $workbook_usecase;

    protected $history_usecase;

    public function __construct(
        WorkbookUsecase $workbook_usecase,
        AnswerHistoryUsecase $history_usecase
    ) {
        $this->workbook_usecase = $workbook_usecase;
        $this->history_usecase = $history_usecase;
    }
    public function list()
    {
        $workbook_dto_list = $this->workbook_usecase->getWorkbookDtoList();
        $user_id = null;
        if (Auth::check()) {
            $user_id = Auth::id();
        }
        return view("workbook_list")
            ->with('workbooks', $workbook_dto_list)
            ->with('user_id', $user_id);
    }
    public function detail($uuid)
    {
        $workbook_dto = $this->workbook_usecase->getWorkbookDto($uuid);
        return view('workbook_detail')
            ->with('workbook', $workbook_dto)
            ->with('workbook_array', $workbook_dto->toArray());
    }
    public function result($uuid, Request $request)
    {
        $workbook = $this->workbook_usecase->getWorkbook($uuid);
        $answer = new Answer($request);
        if (Auth::check()) {
            $this->history_usecase->addAnswerHistory($answer, $workbook, Auth::user());
        }

        return view('workbook_result')
            ->with('workbook', $workbook->getWorkbookDto())
            ->with('answer', $answer)
            ->with('answer_graph_data', $answer->toGraphData())
            ->with('exercise_count', $answer->getExerciseCount());
    }
}
