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

    public function getWorkbookId() {
        return $this->workbook_id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getExerciseList() {
       return $this->exercise_list;
    }

    public function addExercise(Exercise $exercise) {
        $this->exercise_list[] = $exercise;
    }

    /**
     * 問題集から登録した問題を削除する
     *  登録されていない問題を削除しようとした場合は、想定外の挙動であるため例外を返す
     * @param Exercise $exercise
     * @throws WorkbookDomainException
     */
    public function deleteExercise(Exercise $exercise) {
        if (!in_array($exercise, $this->exercise_list)) {
            throw new WorkbookDomainException("削除対象の要素が配列に存在しません。");
        }
        $this->exercise_list = array_diff($this->exercise_list, [$exercise]);
    }

    public function modifyOrder(Exercise $exercise, $order_num) {
    }
}
