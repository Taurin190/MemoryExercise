<?php

namespace App\Http\Controllers\Workbook;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkbookRequest;
use App\Usecase\ExerciseUsecase;
use App\Usecase\WorkbookUsecase;
use Illuminate\Http\Request;
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

    public function create(Request $request)
    {
        $workbook_dto = $this->workbook_usecase->getWorkbookDtoByRequestSession($request, '_create');
        return view('workbook_create')
            ->with('workbook', $workbook_dto);
    }

    public function add_exercise(WorkbookRequest $request)
    {
        $workbook_dto = $this->workbook_usecase->getWorkbookDtoByRequest($request, Auth::id());
        $request->session()->put('title_create', $workbook_dto->title);
        $request->session()->put('explanation_create', $workbook_dto->explanation);
        return view('workbook_add_exercise');
    }

    public function confirm(Request $request)
    {
        $exercise_list = $this->exercise_usecase->getExerciseDtoListByIdListOfRequest($request);
        $workbook_dto = $this->workbook_usecase->getWorkbookDtoByRequestSession($request, '_create');
        $request->session()->put('title_create', $workbook_dto->title);
        $request->session()->put('explanation_create', $workbook_dto->explanation);
        $request->session()->put('exercise_id_list_create', $request->get('exercise', []));
        return view('workbook_confirm')
            ->with('workbook', $workbook_dto)
            ->with('exercise_list', $exercise_list);
    }

    public function complete(Request $request)
    {
        $this->workbook_usecase->registerWorkbookByRequestSession($request, Auth::user(), '_create');
        return view('workbook_complete');
    }
}
