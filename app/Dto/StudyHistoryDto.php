<?php

namespace App\Dto;

class StudyHistoryDto
{
    public $exerciseDateCountMap;

    public $labels = [];

    public $monthlyCount;

    public $totalCount;

    public $totalDays;

    public $graphData;

    private function __construct($exerciseHistoryTable, $monthlyCount, $totalCount, $totalDays)
    {
        $this->labels = $exerciseHistoryTable->getDateLabelList();
        $this->exerciseDateCountMap = $exerciseHistoryTable->getDailyCountTable();
        $this->monthlyCount = $monthlyCount;
        $this->totalCount = $totalCount;
        $this->totalDays = $totalDays;
        $data_list = [];
        foreach ($this->exerciseDateCountMap as $count) {
            $data_list[] = $count;
        }
        $this->graphData = [
            "datasets" => [
                "data" => $data_list,
                "label" => "学習履歴",
                "backgroundColor" => "#f87979"
            ],
            "labels" => $this->labels
        ];

    }

    public static function map($exercise_history_table, $monthly_count, $total_count, $total_days)
    {
        return new StudyHistoryDto($exercise_history_table, $monthly_count, $total_count, $total_days);
    }
}
