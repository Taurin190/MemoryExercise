<?php
namespace App\Domain;

interface WorkbookRepository
{
    function save(Workbook $workbook);

    function update(Workbook $workbook);

    function findByWorkbookId($workbook_id);

    function findAll();

    function delete($workbook_id);
}
