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

    public function toArray()
    {
        $exercise_list_array = [];
        foreach ($this->exercise_dto_list as $exercise_dto) {
            $exercise_list_array[] = $exercise_dto->toArray();
        }
        return $exercise_list_array;
    }
}
