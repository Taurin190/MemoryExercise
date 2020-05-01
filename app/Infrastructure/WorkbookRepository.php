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
        $domain_list = [];
        $all_model = \App\Workbook::all();
        foreach ($all_model as $model) {
            $domain_list[] = Workbook::map($model);
        }
        return $domain_list;
    }

    function save(Workbook $workbook)
    {
        \App\Workbook::map($workbook)->save();
    }

    function delete(int $workbook_id)
    {
        \App\Workbook::find($workbook_id)->delete();
    }
}
