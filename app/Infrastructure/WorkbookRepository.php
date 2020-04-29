<?php
namespace App\Infrastructure;
use App\Domain\Workbook;

class WorkbookRepository implements \App\Domain\WorkbookRepository
{
    function findByWorkbookId(int $workbook_id)
    {
        $model = \App\Workbook::find($workbook_id);
        return Workbook::map($model->first());
    }

    function findAll()
    {
    }

    function save(Workbook $workbook)
    {
    }

    function delete()
    {
    }
}
