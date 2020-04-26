<?php

namespace App\Domain;


class Workbook
{
    private $workbook_id;

    private $title;

    private $description;

    private $exercise_list = [];

    /**
     * 問題集を作成するFactoryMethod
     * @param $title string 問題集のタイトル
     * @param $description string 問題集の説明
     * @return Workbook 作成した問題集
     * @throws WorkbookDomainException
     */
    public static function create($title, $description) {
        if (empty($title)) {
            throw new WorkbookDomainException("タイトルが空です。");
        }
        $workbook = new Workbook($title, $description);
        return $workbook;
    }

    private function __construct($title, $description) {
        $this->title = $title;
        $this->description = $description;
    }

    public function addExercise(Exercise $exercise) {
    }

    public function deleteExercise(Exercise $exercise) {
    }

    public function modifyOrder(Exercise $exercise, $order_num) {
    }
}
