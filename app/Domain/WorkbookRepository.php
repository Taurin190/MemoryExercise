<?php
namespace App\Domain;

interface WorkbookRepository
{
    public function save(Workbook $workbook);

    public function update(Workbook $workbook);

    //TODO privateを取得するためにUserの追加が必要
    public function findByWorkbookId($workbook_id);

    public function findWorkbooks();

    public function delete($workbook_id);
}
