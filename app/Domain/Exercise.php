<?php

namespace App\Domain;

use App\Dto\ExerciseDto;

class Exercise
{
    const PUBLIC_EXERCISE = 1;

    const PRIVATE_EXERCISE = 0;

    private $exercise_id;

    private $question;

    private $answer;

    private $permission;

    private $author_id;

    private $label_list;

    /**
     * Exerciseドメインモデルのコンストラクタ
     * @param string $exercise_id primary id。データベースにデータ作成時にidが決まるため作成時にはnullになる。
     * @param string $question 問題の質問
     * @param string $answer 問題の解答
     * @param int $permission 公開範囲の設定
     * @param array $label_list ラベル。任意で設定可能
     * @param int $author_id
     */
    private function __construct($exercise_id, $question, $answer, $permission, $label_list, $author_id)
    {
        $this->question = $question;
        $this->answer = $answer;
        $this->exercise_id = $exercise_id;
        $this->permission = $permission;
        $this->label_list = $label_list;
        $this->author_id = $author_id;
    }

    public static function create($parameters)
    {
        if (empty($parameters['question'])) {
            throw new DomainException("質問が空です。");
        }
        if (empty($parameters['answer'])) {
            throw new DomainException("解答が空です。");
        }
        $permission = self::PUBLIC_EXERCISE;
        if (isset($parameters['permission'])) {
            $permission = (int)$parameters['permission'];
        }
        $exercise_id = null;
        if (isset($parameters['exercise_id'])) {
            $exercise_id = $parameters['exercise_id'];
        }
        $label_list = [];
        if (isset($parameters['label_list'])) {
            $label_list = $parameters['label_list'];
        }
        $author_id = 0;
        if (isset($parameters['author_id'])) {
            $author_id = $parameters['author_id'];
        }

        return new Exercise(
            $exercise_id,
            $parameters['question'],
            $parameters['answer'],
            $permission,
            $label_list,
            $author_id
        );
    }

    public static function createFromDto(ExerciseDto $exercise_dto): Exercise
    {
        return Exercise::create([
            "exercise_id" => $exercise_dto->exercise_id,
            "question" => $exercise_dto->question,
            "answer" => $exercise_dto->answer,
            "permission" => $exercise_dto->permission,
            "label_list" => $exercise_dto->label_list,
            "author_id" => $exercise_dto->user_id
        ]);
    }

    public static function convertDomain(\App\Exercise $exercise_orm): Exercise
    {
        return Exercise::create([
            "exercise_id" => $exercise_orm->getKey(),
            "question" => $exercise_orm->getAttribute("question"),
            "answer" => $exercise_orm->getAttribute("answer"),
            "permission" => $exercise_orm->getAttribute("permission"),
            "label_list" => $exercise_orm->getAttribute("label_list"),
            "author_id" => $exercise_orm->getAttribute("author_id")
        ]);
    }

    public function getExerciseDto(): ExerciseDto
    {
        return new ExerciseDto(
            $this->question,
            $this->answer,
            $this->permission,
            $this->author_id,
            $this->exercise_id,
            $this->label_list
        );
    }

    public function getExerciseId()
    {
        return $this->exercise_id;
    }

    public function isRegisteredDomain()
    {
        return isset($this->exercise_id);
    }

    public function hasEditPermission($user_id)
    {
        return $this->author_id == $user_id;
    }

    public function edit($parameters): void
    {
        if (!empty($parameters['question'])) {
            $this->question = $parameters['question'];
        }
        if (!empty($parameters['answer'])) {
            $this->answer = $parameters['answer'];
        }
        if (isset($parameters['permission'])) {
            $this->permission = $parameters['permission'];
        }
        if (isset($parameters['label_list'])) {
            $this->label_list = $parameters['label_list'];
        }
    }

    public function toArray()
    {
        return $exercise_array = [
            'exercise_id' => $this->exercise_id,
            'question' => $this->question,
            'answer' => $this->answer
        ];
    }
}
