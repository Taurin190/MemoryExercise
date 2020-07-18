<?php

namespace App\Domain;

class Workbook
{
    private $workbook_id;

    private $title;

    private $explanation;

    private $exercise_list = [];

    /**
     * 問題集を作成するFactoryMethod
     * @param $title string 問題集のタイトル
     * @param $explanation string 問題集の説明
     * @return Workbook 作成した問題集
     * @throws WorkbookDomainException
     */
    public static function create($title, $explanation) {
        if (empty($title)) {
            throw new WorkbookDomainException("タイトルが空です。");
        }
        $workbook = new Workbook($title, $explanation);
        return $workbook;
    }

    public static function map(\App\Workbook $workbook_model) {
        return new Workbook(
            $workbook_model->getAttribute('title'),
            $workbook_model->getAttribute('explanation'),
            $workbook_model->getKey(),
            $workbook_model->exercises()
        );
    }

    private function __construct($title, $explanation, $workbook_id = null, $exercises = null) {
        if (isset($workbook_id)) {
            $this->workbook_id = $workbook_id;
        }
        if (isset($exercises)) {
            $this->setExerciseList($exercises->get());
        }
        $this->title = $title;
        $this->explanation = $explanation;
    }

    public function getWorkbookId() {
        return $this->workbook_id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getExplanation() {
        return $this->explanation;
    }

    public function modifyTitle($title) {
        if (empty($title)) {
            throw new WorkbookDomainException("タイトルが空です。");
        }
        $this->title = $title;
    }
    public function modifyExplanation($explanation) {
        $this->explanation = $explanation;
    }

    public function getExerciseList() {
       return $this->exercise_list;
    }

    public function addExercise(Exercise $exercise) {
        $this->exercise_list[] = $exercise;
    }

    /**
     * 問題集に登録している問題の順番を入れ替える
     * @param Exercise $exercise
     * @param int $order_num
     * @throws WorkbookDomainException
     */
    public function modifyOrder(Exercise $exercise, int $order_num) {
        $insert_num = $order_num - 1;
        $exercise_amount = count($this->exercise_list);
        // 要素が1つ以下の場合は、例外を返さないように処理を行わない。
        if ($exercise_amount <= 1) {
            return;
        }
        if ($insert_num < 0 || $exercise_amount <= $insert_num) {
            throw new WorkbookDomainException("指定された順番が不正です。");
        }
        $tmp_exercise_list = array_diff($this->exercise_list, [$exercise]);
        $new_exercise_list = [];

        for ($i = 0; $i < $exercise_amount; $i++) {
            if ($i == $insert_num) {
                $new_exercise_list[] = $exercise;
                continue;
            }
            $new_exercise_list[] = $tmp_exercise_list[0];
            array_shift($tmp_exercise_list);
        }
        $this->exercise_list = $new_exercise_list;
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

    private function setExerciseList($exercise_list) {
        $domain_list = [];
        foreach($exercise_list as $model) {
            $domain_list[] = Exercise::map($model);
        }
        $this->exercise_list = $domain_list;
    }

    public function setExerciseDomainList($exercise_domain_list) {
        $this->exercise_list = $exercise_domain_list;
    }

    public function toArray() {
        $exercise_json_array = [];
        foreach ($this->exercise_list as $exercise) {
            $exercise_json_array[] = $exercise->toArray();
        }
        $workbook_array = [
            'workbook_id' => $this->workbook_id,
            'title' => $this->title,
            'explanation' => $this->explanation,
            'exercise_list' => $exercise_json_array
        ];
        return $workbook_array;
    }
}
