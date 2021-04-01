<?php


namespace App\Domain;

use App\Dto\ExerciseListDto;

class SearchExerciseList
{
    private $exerciseListDomain;

    private $totalCount;

    private $page;

    private $queryText;

    public function __construct($exercise_list_domain, $total_count, $page, $query_text)
    {
        $this->exerciseListDomain = $exercise_list_domain;
        $this->totalCount = $total_count;
        $this->page = $page;
        $this->queryText = $query_text;
    }

    public function getExerciseListDto()
    {
        return new ExerciseListDto(
            $this->totalCount,
            $this->exerciseListDomain->getExerciseDtoList(),
            $this->page
        );
    }

    public function count()
    {
        return count($this->exerciseListDomain->getExerciseDtoList());
    }
}
