<?php

namespace App\Domain;

use App\Dto\WorkbookDto;
use App\User;

class Workbook
{
    const ADMIN_USER_ID = 1;

    private $workbook_id;

    private $title;

    private $explanation;

    private $exercises = null;

    private $user_id;

    /**
     * 問題集を作成するFactoryMethod
     * @param $parameters array 問題集の情報を入れた連想配列
     * @return Workbook 作成した問題集
     * @throws DomainException
     */
    public static function create($parameters)
    {
        if (empty($parameters['title'])) {
            throw new DomainException("タイトルが空です。");
        }
        $explanation = null;
        if (isset($parameters['explanation'])) {
            $explanation = $parameters['explanation'];
        }
        $exercise_list = null;
        if (isset($parameters['exercise_list'])) {
            if (!($parameters['exercise_list'] instanceof Exercises)) {
                throw new DomainException("Invalid Type Error.");
            }
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

    public static function convertDomain(\App\Workbook $workbook_orm)
    {
        return new Workbook(
            $workbook_orm->getAttribute('title'),
            $workbook_orm->getAttribute('explanation'),
            $workbook_orm->getKey(),
            Exercises::convertByOrmList($workbook_orm->exercises()->get()),
            $workbook_orm->getAttribute('user')
        );
    }

    public function hasEditPermission($user_id)
    {
        return $this->user_id == $user_id;
    }

    //TODO user出なくてuser_idで作成したい。
    private function __construct(
        string $title,
        string $explanation,
        string $workbook_id = null,
        Exercises $exercises = null,
        User $user = null
    ) {
        if (isset($workbook_id)) {
            $this->workbook_id = $workbook_id;
        }
        if (isset($exercises)) {
            $this->exercises = $exercises;
        }
        if (isset($user)) {
            $this->user_id = $user->getKey();
        } else {
            $this->user_id = self::ADMIN_USER_ID;
        }
        $this->title = $title;
        $this->explanation = $explanation;
    }

    public function getWorkbookDto()
    {
        $exercise_dto_list = [];
        if (isset($this->exercises)) {
            $exercise_dto_list = $this->exercises->getExerciseDtoList();
        }

        return new WorkbookDto(
            $this->title,
            $this->explanation,
            $exercise_dto_list,
            $this->user_id,
            $this->workbook_id
        );
    }

    public function getWorkbookId()
    {
        return $this->workbook_id;
    }

    public function edit($parameters)
    {
        if (!empty($parameters['title'])) {
            $this->title = $parameters['title'];
        }
        if (!empty($parameters['explanation'])) {
            $this->explanation = $parameters['explanation'];
        }
        if (isset($parameters['exercise_list'])) {
            if (!($parameters['exercise_list'] instanceof Exercises)) {
                throw new DomainException("Invalid Type Error.");
            }
            $this->exercises = $parameters['exercise_list'];
        }
    }

    public function getWorkbookExerciseRelationList($workbook_id)
    {
        return $this->exercises->getWorkbookExerciseRelationList($workbook_id);
    }

    //TODO 消したい
    public function getExerciseList()
    {
        return $this->exercises;
    }

    public function getCountOfExercise()
    {
        if ($this->exercises == null) {
            return 0;
        }
        return $this->exercises->count();
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function addExercise(Exercise $exercise)
    {
        $this->exercises[] = $exercise;
    }

    /**
     * 問題集に登録している問題の順番を入れ替える
     * @param Exercise $exercise
     * @param int $order_num
     * @throws WorkbookDomainException
     */
    public function modifyOrder(Exercise $exercise, int $order_num)
    {
        $insert_num = $order_num - 1;
        $exercise_amount = $this->exercises->count();
        // 要素が1つ以下の場合は、例外を返さないように処理を行わない。
        if ($exercise_amount <= 1) {
            return;
        }
        if ($insert_num < 0 || $exercise_amount <= $insert_num) {
            throw new WorkbookDomainException("指定された順番が不正です。");
        }
        $tmp_exercise_list = array_diff($this->exercises, [$exercise]);
        $new_exercise_list = [];

        for ($i = 0; $i < $exercise_amount; $i++) {
            if ($i == $insert_num) {
                $new_exercise_list[] = $exercise;
                continue;
            }
            $new_exercise_list[] = $tmp_exercise_list[0];
            array_shift($tmp_exercise_list);
        }
        $this->exercises = $new_exercise_list;
    }

    public function toArray()
    {
        $exercise_json_array = $this->exercises->toArray();
        $workbook_array = [
            'workbook_id' => $this->workbook_id,
            'title' => $this->title,
            'explanation' => $this->explanation,
            'exercise_list' => $exercise_json_array
        ];
        return $workbook_array;
    }
}
