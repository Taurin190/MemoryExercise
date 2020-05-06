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
                [
                    'workbook_id' => 'test4',
                    'title' => '基本情報技術者試験',
                    'explanation' => '情報処理技術者試験は、「情報処理の促進に関する法律」に基づき経済産業省が、
                    情報処理技術者としての「知識・技能」が一定以上の水準であることを認定している国家試験です。',
                ],
            ];
        foreach ($workbooks as $workbook) {
            DB::table('workbooks')->insert($workbook);
        }
    }
}
