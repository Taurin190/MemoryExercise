<?php
namespace App\Infrastructure;
use App\Domain\Workbook;

class WorkbookRepository implements \App\Domain\WorkbookRepository
{
    private $model;

    function __construct(\App\Workbook $workbook_model)
    {
        $this->model = $workbook_model;
    }

    function save(Workbook $workbook)
    {
    }

    function findByWorkbookId(int $workbook_id)
    {
    }

    function findAll()
    {
    }

    function delete()
    {
    }
}
