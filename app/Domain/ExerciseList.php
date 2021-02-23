<?php


namespace App\Domain;


class ExerciseList
{
    private $exercise_list;

    private $exercise_dto_list;

    public function __construct($exercise_orm_list)
    {
        foreach ($exercise_orm_list as $exercise_orm) {
            $domain = Exercise::convertDomain($exercise_orm);
            $this->exercise_list[] = $domain;
            $this->exercise_dto_list[] = $domain->getExerciseDto();
        }
    }

    public function getExerciseDtoList(){
        return $this->exercise_dto_list;
    }
}
