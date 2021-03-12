<?php

namespace App\Domain;

use App\Dto\ExerciseDto;
use App\Dto\WorkbookDto;
use App\User;

class Workbook
{
    const ADMIN_USER_ID = 1;

    private $workbook_id;

    private $title;

    private $explanation;

    //TODO Arrayなど混在しているのでExerciseListのクラスに統一する
    private $exercise_list = [];

    private $user_id;

    /**
     * 問題集を作成するFactoryMethod
     * @param $parameters array 問題集の情報を入れた連想配列
     * @return Workbook 作成した問題集
     * @throws WorkbookDomainException
     */
    public static function create($parameters) {
        if (empty($parameters['title'])) {
            throw new WorkbookDomainException("タイトルが空です。");
        }
        $explanation = null;
        if (isset($parameters['explanation'])) {
            $explanation = $parameters['explanation'];
        }
        $exercise_list = null;
        if (isset($parameters['exercise_list'])) {
            $exercise_list = $parameters['exercise_list'];
        }
        $workbook_id = null;
        if (isset($parameters['workbook_id'])) {
            $workbook_id = $parameters['workbook_id'];
        }
        $user = null;
        if (isset($parameters['user'])) {
            $user = $parameters['user'];
        }
        return new Workbook($parameters['title'], $explanation, $workbook_id, $exercise_list, $user);
    }

    public static function convertDomain(\App\Workbook $workbook_orm) {
        return new Workbook(
            $workbook_orm->getAttribute('title'),
            $workbook_orm->getAttribute('explanation'),
            $workbook_orm->getKey(),
            $workbook_orm->exercises(),
            $workbook_orm->getAttribute('user')
        );
    }

    public function hasEditPermission($user_id) {
    return $this->user_id == $user_id;
}

    //TODO user出なくてuser_idで作成したい。
    private function __construct($title, $explanation, $workbook_id = null, $exercises = null, User $user = null) {
        if (isset($workbook_id)) {
            $this->workbook_id = $workbook_id;
        }
        if (isset($exercises)) {
            if (is_array($exercises)) {
                $this->setExerciseList($exercises);
            } else if ($exercises instanceof ExerciseList) {
                $this->setExerciseDomainList($exercises->getDomainList());
            } else {
                $this->setExerciseList($exercises->get());
            }
        }
        if (isset($user)) {
            $this->user_id = $user->getKey();
        } else {
            $this->user_id = self::ADMIN_USER_ID;
        }
        $this->title = $title;
        $this->explanation = $explanation;
    }

    public function getWorkbookDto() {
        $exercise_dto_list = [];
        foreach($this->exercise_list as $exercise) {
            $exercise_dto_list[] = $exercise->getExerciseDto();
        }
        return new WorkbookDto(
            $this->title,
            $this->explanation,
            $exercise_dto_list,
            $this->user_id,
            $this->workbook_id
        );
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

    public function edit($parameters) {
        if (!empty($parameters['title'])) {
            $this->title = $parameters['title'];
        }
        if (!empty($parameters['explanation'])) {
            $this->explanation = $parameters['explanation'];
        }
        if (isset($parameters['exercise_list'])) {
            $this->exercise_list = $parameters['exercise_list'];
        }
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

    public function getWorkbookExerciseRelationList($workbook_id)
    {
        if ($this->exercise_list instanceof ExerciseList) {
            return $this->exercise_list->getWorkbookExerciseRelationList($workbook_id);
        }
        //TODO コレクションオブジェクトに統一して以下の処理を削除する
        $workbook_exercise_relation_list = [];
        foreach ($this->exercise_list as $exercise) {
            $workbook_exercise_relation_list[] = [
                'exercise_id' => $exercise->getExerciseId(),
                'workbook_id' => $workbook_id
            ];
        }
        return $workbook_exercise_relation_list;
    }

    public function getExerciseList() {
       return $this->exercise_list;
    }

    public function getCountOfExercise() {
        if ($this->exercise_list == null) return 0;
        //TODO コレクションオブジェクトに統一して分岐を無くす。
        if ($this->exercise_list instanceof ExerciseList) {
            return count($this->exercise_list->getDomainList());
        }
        return count($this->exercise_list);

    }
    public function getUserId() {
        return $this->user_id;
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
            if ($model instanceof Exercise) {
                $domain_list[] = $model;
            } else {
                $domain_list[] = Exercise::convertDomain($model);
            }
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
