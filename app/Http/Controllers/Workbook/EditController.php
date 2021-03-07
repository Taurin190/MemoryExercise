<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/08/06
 * Time: 22:32
 */

namespace App\Http\Controllers\Workbook;


use App\Domain\WorkbookDomainException;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkbookRequest;
use App\Usecase\ExerciseUsecase;
use App\Usecase\WorkbookUsecase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $workbook = $this->workbook_usecase->getWorkbookDtoByIdForEdit($uuid, Auth::id());
        return view('workbook_edit')
            ->with('workbook', $workbook);
    }

    public function edit_exercise($uuid, WorkbookRequest $request)
    {
        $workbook_dto = $this->workbook_usecase->getEditedWorkbookDtoByRequest($uuid, $request, Auth::id());
        $request->session()->put('title_edit', $workbook_dto->title);
        $request->session()->put('explanation_edit', $workbook_dto->explanation);

        return view('workbook_edit_exercise')
            ->with('workbook', $workbook_dto)
            //TODO Vue.jsで表示するworkbook_arrayを調整する
            ->with('workbook_array', $workbook_dto);
    }

    public function confirm($uuid, WorkbookRequest $request)
    {
        $title = $request->get('title');
        $explanation = $request->get('explanation');
        $exercise_id_list = $request->get('exercise');
        if (isset($exercise_id_list)) {
            $exercise_list = $this->exercise_usecase->getAllExercisesWithIdList($exercise_id_list);
            $workbook = $this->workbook_usecase->makeWorkbook($title, $explanation, $exercise_list, $uuid);
            return view('workbook_edit_confirm')
                ->with('workbook', $workbook)
                ->with('exercise_list', $exercise_list);
        } else {
            $workbook = $this->workbook_usecase->makeWorkbook($title, $explanation, null, $uuid);
            return view('workbook_edit_confirm')
                ->with('workbook', $workbook);
        }
    }

    public function complete($uuid, Request $request)
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
