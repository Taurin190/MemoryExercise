<?php


namespace App\Domain;


class ExerciseList
{
    private $exercise_list;

    private $exercise_dto_list;

    private function __construct() {}

    public function getExerciseDtoList()
    {
        return $this->exercise_dto_list;
    }

    public function getDomainList()
    {
        return $this->exercise_list;
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
        $instance = new ExerciseList();
        $instance->setExerciseList($exercise_list);
        $instance->setExerciseDtoList($exercise_dto_list);
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
        $instance = new ExerciseList();
        $instance->setExerciseList($exercise_list);
        $instance->setExerciseDtoList($exercise_dto_list);
        return $instance;
    }

    public function getWorkbookExerciseRelationList($workbook_id)
    {
        $workbook_exercise_relation_list = [];
        foreach ($this->exercise_dto_list as $exercise_dto) {
            $workbook_exercise_relation_list[] = [
                ['workbook_id' => $workbook_id],
                ['exercise_id' => $exercise_dto->exercise_id]
            ];
        }
        return $workbook_exercise_relation_list;
    }

    private function setExerciseList($exercise_list)
    {
        $this->exercise_list = $exercise_list;
    }

    private function setExerciseDtoList($exercise_dto_list)
    {
        $this->exercise_dto_list = $exercise_dto_list;
    }
}
