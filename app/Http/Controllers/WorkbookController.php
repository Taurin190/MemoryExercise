<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/05/03
 * Time: 7:15
 */

namespace App\Http\Controllers;
use App\Usecase\WorkbookUsecase;
use App\Domain\Answer;
use Illuminate\Http\Request;

class WorkbookController extends Controller
{
    protected $workbook_usecase;

    public function __construct(WorkbookUsecase $workbook_usecase) {
        $this->workbook_usecase = $workbook_usecase;
    }
    public function list()
    {
        $workbook_list = $this->workbook_usecase->getAllWorkbook();

        return view("workbook_list")->with('workbooks', $workbook_list);
    }
    public function detail($uuid)
    {
        $workbook = $this->workbook_usecase->getWorkbook($uuid);
        return view('workbook_detail')->with('workbook', $workbook);
    }
    public function complete($uuid, Request $request)
    {
        $workbook = $this->workbook_usecase->getWorkbook($uuid);
        $answer = new Answer($request);
        return view('workbook_complete')->with('workbook', $workbook)->with('answer', $answer);
    }
}
