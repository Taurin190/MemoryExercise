<?php


namespace App\Dto;


class AnswerDto
{
    public $exercise_list = [];

    public $exercise_map = [];

    public $ok_count = 0;

    public $ng_count = 0;

    public $studying_count = 0;

    public $workbook_id;

    public function __construct($exercise_list, $answer_list)
    {
        $this->exercise_list = $exercise_list;
        foreach ($this->exercise_list as $exercise) {
            if (!isset($answer_list[$exercise])) {
                continue;
            }
            $this->exercise_map[$exercise] = $answer_list[$exercise];
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
                    break;
            }
        }
    }

    public function toGraphData()
    {
        return [
            'labels' => ['OK', 'Studying', 'NG'],
            'datasets' => [
                'label' => '回答数',
                'backgroundColor' => '#f87979',
                'data' => [
                    $this->ok_count,
                    $this->studying_count,
                    $this->ng_count
                ],
            ],
        ];
    }

    public function getExerciseCount()
    {
        return count($this->exercise_list);
    }
}
