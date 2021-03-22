<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/08/06
 * Time: 22:32
 */

namespace App\Http\Controllers\Workbook;

use App\Http\Controllers\Controller;
use App\Usecase\ExerciseUsecase;
use App\Usecase\WorkbookUsecase;
use Illuminate\Support\Facades\Auth;

class DeleteController extends Controller
{
    protected $workbook_usecase;

    protected $exercise_usecase;

    public function __construct(WorkbookUsecase $workbook_usecase, ExerciseUsecase $exercise_usecase)
    {
        $this->middleware('auth');
        $this->workbook_usecase = $workbook_usecase;
        $this->exercise_usecase = $exercise_usecase;
    }


    public function complete($uuid)
    {
        $this->workbook_usecase->deleteWorkbook($uuid, Auth::id());
        return view('workbook_delete_complete');
    }
}
