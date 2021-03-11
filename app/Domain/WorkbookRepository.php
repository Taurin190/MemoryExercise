<?php
namespace App\Domain;

interface WorkbookRepository
{
    function save(Workbook $workbook);

    function update(Workbook $workbook);

    //TODO privateを取得するためにUserの追加が必要
    function findByWorkbookId($workbook_id);

    function findAll();

    function delete($workbook_id);

    function checkEditPermission($workbook_id, $user_id);
}
