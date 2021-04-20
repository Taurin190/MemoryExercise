<?php

namespace App\Http\Controllers;

use App\Dto\AnswerDto;
use App\Usecase\StudyHistoryUsecase;
use App\Usecase\WorkbookUsecase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkbookController extends Controller
{
    protected $workbook_usecase;

    protected $study_history_usecase;

    public function __construct(
        WorkbookUsecase $workbook_usecase,
        StudyHistoryUsecase $study_history_usecase
    ) {
        $this->workbook_usecase = $workbook_usecase;
        $this->study_history_usecase = $study_history_usecase;
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
        $workbook_dto = $this->workbook_usecase->getWorkbook($uuid);
        return view('workbook_detail')
            ->with('workbook', $workbook_dto)
            ->with('workbook_array', $workbook_dto->toArray());
    }
    public function result($uuid, Request $request)
    {
        $workbook_dto = $this->workbook_usecase->getWorkbook($uuid);
        $answer_dto = new AnswerDto(
            $request->get('exercise_list', []),
            $request->get('answer', [])
        );
        if (Auth::check()) {
            $this->study_history_usecase->saveStudyHistory($uuid, $answer_dto->exercise_num_map, Auth::id());
        }

        return view('workbook_result')
            ->with('workbook', $workbook_dto)
            ->with('answer', $answer_dto)
            ->with('answer_graph_data', $answer_dto->toGraphData())
            ->with('exercise_count', $answer_dto->getExerciseCount());
    }
}
