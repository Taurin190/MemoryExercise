<?php


namespace App\Domain;

class Exercises
{
    private $exercise_list;

    private $exercise_dto_list;

    private function __construct()
    {
    }

    public function getExerciseDtoList()
    {
        return $this->exercise_dto_list;
    }

    public function count()
    {
        return count($this->exercise_dto_list);
    }

    public static function convertByOrmList($exercise_orm_list)
    {
        $exercise_list = [];
        $exercise_dto_list = [];
        foreach ($exercise_orm_list as $exercise_orm) {
            $domain = Exercise::convertDomain($exercise_orm);
            $exercise_list[] = $domain;
            $exercise_dto_list[] = $domain->getExerciseDto();
        }
        $instance = new Exercises();
        $instance->exercise_list = $exercise_list;
        $instance->exercise_dto_list = $exercise_dto_list;
        return $instance;
    }

    public static function convertByDtoList(array $exercise_dto_list)
    {
        $exercise_list = [];
        foreach ($exercise_dto_list as $exercise_dto) {
            $domain = Exercise::create([
                'question' => $exercise_dto->question,
                'answer' => $exercise_dto->answer,
                'permission' => $exercise_dto->permission,
                'author_id' => $exercise_dto->user_id,
                'label_list' => $exercise_dto->label_list,
                'exercise_id' => $exercise_dto->exercise_id
            ]);
            $exercise_list[] = $domain;
        }
        $instance = new Exercises();
        $instance->exercise_list = $exercise_list;
        $instance->exercise_dto_list = $exercise_dto_list;
        return $instance;
    }

    public function getWorkbookExerciseRelationList($workbook_id)
    {
        $workbook_exercise_relation_list = [];
        foreach ($this->exercise_dto_list as $exercise_dto) {
            $workbook_exercise_relation_list[] = [
                'exercise_id' => $exercise_dto->exercise_id,
                'workbook_id' => $workbook_id
            ];
        }
        return $workbook_exercise_relation_list;
    }

    public function toArray()
    {
        $exercise_array = [];
        foreach ($this->exercise_list as $exercise) {
            $exercise_array[] = $exercise->toArray();
        }
        return $exercise_array;
    }
}
