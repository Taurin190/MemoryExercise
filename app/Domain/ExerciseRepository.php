<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/04/26
 * Time: 6:39
 */

namespace App\Domain;


interface ExerciseRepository
{
    function save(Workbook $workbook);

    function findByWorkbookId(int $workbook_id);

    function findAll();

    function delete();
}
