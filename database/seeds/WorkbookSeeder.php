<?php

use Illuminate\Database\Seeder;

class WorkbookSeeder extends Seeder
{
    public function run() {
        $workbooks =
            [
                [
                    'workbook_id' => 'test1',
                    'title' => 'test workbook1',
                    'explanation' => 'this is sample workbook no.1',
                ],
                [
                    'workbook_id' => 'test2',
                    'title' => 'test workbook2',
                    'explanation' => 'this is sample workbook no.2',
                ],
                [
                    'workbook_id' => 'test3',
                    'title' => 'test workbook3',
                    'explanation' => 'this is sample workbook no.3',
                ],
            ];
        foreach ($workbooks as $workbook) {
            DB::table('workbooks')->insert($workbook);
        }
    }
}
