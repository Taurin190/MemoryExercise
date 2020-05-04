<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/05/03
 * Time: 7:15
 */

namespace App\Http\Controllers;
use App\Usecase\WorkbookUsecase;

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

}
