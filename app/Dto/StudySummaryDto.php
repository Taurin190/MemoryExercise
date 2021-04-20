<?php


namespace App\Dto;


use DateTime;

class StudySummaryDto
{
    public $exerciseCountInMonth;

    public $totalExerciseCount;

    public $totalStudyDays;

    public $graphData;

    public function __construct($exerciseCountInMonth, $totalExerciseCount, $totalStudyDays, $exerciseCountMap)
    {
        $this->exerciseCountInMonth = $exerciseCountInMonth;
        $this->totalExerciseCount = $totalExerciseCount;
        $this->totalStudyDays = $totalStudyDays;
        $this->graphData = $this->createGraphData($exerciseCountMap);
    }

    private function createGraphData($exerciseCountMap)
    {
        $labelList = [];
        $exerciseCountList = [];
        foreach ($exerciseCountMap as $label => $exerciseCount) {
            $date = new DateTime($label);
            $labelList[] = $date->format('n/j');
            $exerciseCountList[] = $exerciseCount;
        }
        return [
            "datasets" => [
                "data" => $exerciseCountList,
                "label" => "学習履歴",
                "backgroundColor" => "#f87979"
            ],
            "labels" => $labelList
        ];
    }
}
