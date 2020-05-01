<?php
namespace App\Domain;

interface WorkbookRepository
{
    function save(Workbook $workbook);

    function findByWorkbookId(int $workbook_id);

    function findAll();

    function delete(int $workbook_id);
}
