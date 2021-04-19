<?php


namespace App\Domain;


use App\Dto\StudySummaryDto;
use DateTime;

class StudySummary
{
    private $exerciseCountInMonth;

    private $totalExerciseCount;

    private $totalStudyDays;

    private $dateExerciseCountList = [];

    private $dateExerciseCountMap = [];

    private $dateLabelList = [];

    private $startDate;

    private $endDate;

    private $graphData = [];

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

        $startDate = new DateTime('first day of this month');
        if (isset($parameters['start_date'])) {
            $startDate = new DateTime($parameters['start_date']);
        }
        $endDate = new DateTime('last day of this month');
        if (isset($parameters['end_date'])) {
            $endDate = new DateTime($parameters['end_date']);
        }

        $this->exerciseCountInMonth = $exerciseCountInMonth;
        $this->totalExerciseCount = $totalExerciseCount;
        $this->totalStudyDays = $totalStudyDays;

        for ($i = $startDate; $i <= $endDate; $i->modify('+1 day')) {
            $exerciseCount = 0;
            if (isset($dateExerciseCountMap[$i->format('Y-m-d')])) {
                $exerciseCount = $dateExerciseCountMap[$i->format('Y-m-d')];
            }
            $this->dateExerciseCountMap[$i->format('Y-m-d')] = $exerciseCount;
            $this->dateLabelList[] = $i->format('n/j');
            $this->dateExerciseCountList[] = new DateExerciseCount($i, $exerciseCount);
        }

        $this->createGraphData($this->dateExerciseCountMap);
    }

    public static function create($parameters)
    {
        return new StudySummary($parameters);
    }

    public function getDto()
    {
        return new StudySummaryDto(
            $this->exerciseCountInMonth,
            $this->totalExerciseCount,
            $this->totalStudyDays,
            $this->graphData
        );
    }

    private function createGraphData($dateExerciseCountMap)
    {
        $this->graphData = [
            "datasets" => [
                "data" => $dateExerciseCountMap,
                "label" => "学習履歴",
                "backgroundColor" => "#f87979"
            ],
            "labels" => $this->dateLabelList
        ];
    }
}
