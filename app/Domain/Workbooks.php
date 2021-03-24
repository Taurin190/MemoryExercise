<?php


namespace App\Domain;


class Workbooks
{
    private $workbook_list = [];

    private $workbook_dto_list = [];

    private function __construct()
    {
    }

    public static function convertByOrmList($workbook_list_orm): Workbooks
    {
        $instance = new Workbooks();
        foreach ($workbook_list_orm as $workbook_orm) {
            $workbook_domain = Workbook::convertDomain($workbook_orm);
            $instance->workbook_list[] = $workbook_domain;
            $instance->workbook_dto_list[] = $workbook_domain->getWorkbookDto();
        }
        return $instance;
    }

    public function getWorkbookDtoList(): array
    {
        return $this->workbook_dto_list;
    }

    public function count(): int
    {
        return count($this->workbook_dto_list);
    }
}
