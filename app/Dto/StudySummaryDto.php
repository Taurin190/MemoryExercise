<?php


namespace App\Dto;


class StudySummaryDto
{
    public $exerciseCountInMonth;

    public $totalExerciseCount;

    public $totalStudyDays;

    public $graphData;

    public function __construct($exerciseCountInMonth, $totalExerciseCount, $totalStudyDays, $graphData)
    {
        $this->exerciseCountInMonth = $exerciseCountInMonth;
        $this->totalExerciseCount = $totalExerciseCount;
        $this->totalStudyDays = $totalStudyDays;
        $this->graphData = $graphData;
    }
}
