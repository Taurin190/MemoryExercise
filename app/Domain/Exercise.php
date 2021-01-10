<?php
namespace App\Domain;

class Exercise
{
    const PUBLIC_EXERCISE = 1;

    const PRIVATE_EXERCISE = 0;

    private $exercise_id;

    private $question;

    private $answer;

    private $permission;

    private $lable_list;

    /**
     * Exerciseドメインモデルのコンストラクタ
     * @param string $exercise_id primary id。データベースにデータ作成時にidが決まるため作成時にはnullになる。
     * @param string $question 問題の質問
     * @param string $answer 問題の解答
     * @param int $permission 公開範囲の設定
     * @param null $label_list ラベル。任意で設定可能
     */
    private function __construct($exercise_id, $question, $answer, $permission, $label_list = null)
    {
        $this->question = $question;
        $this->answer = $answer;
        $this->exercise_id = $exercise_id;
        $this->permission = $permission;
    }

    public static function create($parameters) {
        if (empty($parameters['question'])) {
            throw new DomainException("質問が空です。");
        }
        if (empty($parameters['answer'])) {
            throw new DomainException("解答が空です。");
        }
        $permission = self::PUBLIC_EXERCISE;
        if (isset($parameters['permission'])) {
            $permission = (int) $parameters['permission'];
        }
        $exercise_id = null;
        if (isset($parameters['exercise_id'])) {
            $exercise_id = $parameters['exercise_id'];
        }
        return new Exercise($exercise_id, $parameters['question'], $parameters['answer'], $permission);
    }

    public static function map(\App\Exercise $model) {
        return new Exercise(
            $model->getKey(),
            $model->getAttribute("question"),
            $model->getAttribute("answer"),
            self::PUBLIC_EXERCISE
        );
    }

    public function getExerciseId() {
        return $this->exercise_id;
    }

    public function getQuestion() {
        return $this->question;
    }

    public function getAnswer() {
        return $this->answer;
    }

    public function getPermission() {
        return $this->permission;
    }

    public function setQuestion($question) {
        if (empty($question)) {
            throw new DomainException("質問が空です。");
        }
        $this->question = $question;
    }

    public function setAnswer($answer) {
        if (empty($answer)) {
            throw new DomainException("解答が空です。");
        }
        $this->answer = $answer;
    }

    public function toArray() {
        return $exercise_array = [
            'exercise_id' => $this->exercise_id,
            'question' => $this->question,
            'answer' => $this->answer
        ];
    }
}
