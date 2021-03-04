<?php


namespace App\Dto;


class ExerciseListDto
{
    public $total_count;
    public $exercise_dto_list;
    public $page;

    public function __construct($count, $exercise_dto_list, $page)
    {
        $this->total_count = $count;
        $this->exercise_dto_list = $exercise_dto_list;
        $this->page = $page;
    }
}
