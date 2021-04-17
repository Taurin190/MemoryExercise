<?php


namespace App\Domain;


use App\Dto\StudySummaryDto;

class StudySummary
{
    private $exerciseCountInMonth;

    private $totalExerciseCount;

    private $totalStudyDays;

    private $dateExerciseCountList = [];

    private $graphDate = [];

    private function __construct($parameters)
    {
        $exerciseCountInMonth = 0;
        if (isset($parameters['exercise_count_in_month'])) {
            $exerciseCountInMonth = $parameters['exercise_count_in_month'];
        }
        $totalExerciseCount = 0;
        if (isset($parameters['total_exercise_count'])) {
            $totalExerciseCount = $parameters['total_exercise_count'];
        }
        $totalStudyDays = 0;
        if (isset($parameters['total_study_days'])) {
            $totalStudyDays = $parameters['total_study_days'];
        }

        $dateExerciseCountMap = [];
        if (isset($parameters['date_exercise_count_map'])) {
            $dateExerciseCountMap = $parameters['date_exercise_count_map'];
        }

        $this->exerciseCountInMonth = $exerciseCountInMonth;
        $this->totalExerciseCount = $totalExerciseCount;
        $this->totalStudyDays = $totalStudyDays;
        foreach ($dateExerciseCountMap as $date => $exerciseCount) {
            $this->dateExerciseCountList[] = new DateExerciseCount($date, $exerciseCount);
        }
    }

    public static function create($parameters)
    {
        return new StudySummary($parameters);
    }

    public function getDto()
    {
        return new StudySummaryDto($this->exerciseCountInMonth, $this->totalExerciseCount, $this->totalStudyDays, $this->graphDate);
    }
}
