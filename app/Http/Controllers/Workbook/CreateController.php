<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/07/09
 * Time: 18:02
 */

namespace App\Http\Controllers\Workbook;
use App\Domain\WorkbookDomainException;
use App\Http\Controllers\Controller;
use App\Usecase\WorkbookUsecase;
use App\Usecase\ExerciseUsecase;
use App\Http\Requests\WorkbookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class CreateController extends Controller
{
    protected $workbook_usecase;

    protected $exercise_usecase;

    public function __construct(WorkbookUsecase $workbook_usecase, ExerciseUsecase $exercise_usecase) {
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
        $title = $request->get('title');
        $explanation = $request->get('explanation');
        $request->session()->put('title_create', $title);
        $request->session()->put('explanation_create', $explanation);
        try {
            $workbook = $this->workbook_usecase->makeWorkbook($title, $explanation);
            return view('workbook_add_exercise')
                ->with('workbook', $workbook);
        } catch (WorkbookDomainException $e) {
            Log::warning($e);
            return view('workbook_create')
                ->with('error', $e);
        } catch (\Exception $e) {
            return view('workbook_create')
                ->with('error', $e);
        }
    }

    public function confirm(WorkbookRequest $request)
    {
        $title = $request->get('title');
        $explanation = $request->get('explanation');
        $exercise_id_list = $request->get('exercise');
        $exercise_list = null;
        if (isset($exercise_id_list)) {
            $exercise_list = $this->exercise_usecase->getAllExercisesWithIdList($exercise_id_list);
        }
        try {
            $workbook = $this->workbook_usecase->makeWorkbook($title, $explanation);
            return view('workbook_confirm')
                ->with('workbook', $workbook)
                ->with('exercise_list', $exercise_list);
        } catch (WorkbookDomainException $e) {
            Log::warning($e);
            return view('workbook_create')
                ->with('error', $e);
        } catch (\Exception $e) {
            return view('workbook_create')
                ->with('error', $e);
        }

    }

    public function complete(WorkbookRequest $request)
    {
        $title = $request->get('title');
        $explanation = $request->get('explanation');
        $request->session()->forget('title_create');
        $request->session()->forget('explanation_create');
        $exercise_id_list = $request->get('exercise');
        $exercise_list = null;
        if (isset($exercise_id_list)) {
            $exercise_list = $this->exercise_usecase->getAllExercisesWithIdList($exercise_id_list);
        }
        $this->workbook_usecase->createWorkbook($title, $explanation, $exercise_list, Auth::user());

        return view('workbook_complete');
    }
}
