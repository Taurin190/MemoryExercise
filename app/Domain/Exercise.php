<?php
namespace App\Domain;

class Exercise
{
    private $exercise_id;

    private $question;

    private $answer;

    private function __construct($question, $answer, $exercise_id = null)
    {
        $this->question = $question;
        $this->answer = $answer;
        $this->exercise_id = $exercise_id;
    }

    public static function create($question, $answer) {
        if (empty($question)) {
            throw new DomainException("質問が空です。");
        }
        if (empty($answer)) {
            throw new DomainException("解答が空です。");
        }
        return new Exercise($question, $answer);
    }

    public static function map(\App\Exercise $model) {
        return new Exercise(
            $model->getAttributes("question"),
            $model->getAttributes("answer"),
            $model->getAttributes("exercise_id")
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
}
