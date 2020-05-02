<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/05/03
 * Time: 7:15
 */

namespace App\Http\Controllers;


class WorkbookController extends Controller
{
    public function list()
    {
        return view("workbook_list");
    }

}
