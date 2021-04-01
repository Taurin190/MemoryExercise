<?php

use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    public function run() {
        $exercises =
            [
                [
                    'exercise_id' => 'exercise1',
                    'question' => 'Is this a dog?',
                    'answer' => 'Yes, it is',
                    'author_id' => 10
                ],
                [
                    'exercise_id' => 'exercise2',
                    'question' => 'Is this a cat?',
                    'answer' => 'No, it isn\'t.',
                    'author_id' => 10
                ],
                [
                    'exercise_id' => 'exercise3',
                    'question' => 'Is this a pencil?',
                    'answer' => 'Yes, it is',
                    'permission' => 0,
                    'author_id' => 10
                ],
                [
                    'exercise_id' => 'exercise4',
                    'question' => 'RAIDの分類において、ミラーリングを用いることで信頼性を高め、
                    障害発生時には冗長ディスクを用いてデータ復元を行う方式はどれか。',
                    'answer' => 'RAID1',
                    'permission' => 0,
                    'author_id' => 10
                ],
                [
                    'exercise_id' => 'exercise5',
                    'question' => '2台の処理装置から成るシステムがある。少なくともいずれか一方が正常に
                    動作すれば良いときの稼働率と２台とも正常に動作しなければならない時の稼働率のさはいくらか。
                    ここで、処理装置の稼働率はいずれも0.9とし、処理装置以外の要因は考慮しないものとする。',
                    'answer' => '0.09',
                    'author_id' => 15
                ],
            ];
        foreach ($exercises as $exercise) {
            DB::table('exercises')->insert($exercise);
        }
    }
}
