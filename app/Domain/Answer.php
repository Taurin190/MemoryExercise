<?php

namespace App\Domain;

use App\Dto\AnswerDto;

class Answer
{
    protected $exercise_list = [];

    protected $exercise_map = [];

    protected $ok_count = 0;

    protected $ng_count = 0;

    protected $studying_count = 0;

    protected $workbook_id;

    private function __construct($exercise_list, $answer_list)
    {
        if (!is_array($exercise_list)) {
            throw new DomainException("問題集が配列ではありません。");
        }
        if (count($exercise_list) == 0) {
            throw new DomainException("問題集が設定されていません。");
        }
        $this->exercise_list = $exercise_list;
        $this->exercise_map = $answer_list;

        foreach ($exercise_list as $exercise) {
            if (!isset($answer_list[$exercise])) {
                throw new DomainException("回答されていない問題があります。");
            }
            if (!isset($answer_list[$exercise])) {
                continue;
            }
            switch ($answer_list[$exercise]) {
                case 'ok':
                    $this->ok_count++;
                    break;
                case 'ng':
                    $this->ng_count++;
                    break;
                case 'studying':
                    $this->studying_count++;
                    break;
                default:
                    throw new DomainException("不正な回答が設定されています。");
            }
        }
    }

    public static function createFromDto(AnswerDto $answer_dto)
    {
        return new Answer(
            $answer_dto->exercise_list,
            $answer_dto->exercise_map
        );
    }

    public function getExerciseMap()
    {
        return $this->exercise_map;
    }

    public function getExerciseList()
    {
        return $this->exercise_list;
    }

    public function getExerciseCount()
    {
        return count($this->exercise_list);
    }

    public function getOKCount()
    {
        return $this->ok_count;
    }

    public function getNGCount()
    {
        return $this->ng_count;
    }

    public function getStudyingCount()
    {
        return $this->studying_count;
    }
}
