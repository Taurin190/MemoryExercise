<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/08/24
 * Time: 16:44
 */

namespace App\Dto;


use DateTime;

class StudyHistoryDto
{
    private $exerciseDateCountMap;

    private $labels = [];

    private $monthlyCount;

    private $totalCount;

    private $totalDays;

    private function __construct($exerciseHistoryTable, $monthlyCount, $totalCount, $totalDays)
    {
        $this->labels = $exerciseHistoryTable->getDateLabelList();
        $this->exerciseDateCountMap = $exerciseHistoryTable->getDailyCountTable();
        $this->monthlyCount = $monthlyCount;
        $this->totalCount = $totalCount;
        $this->totalDays = $totalDays;
    }

    public static function map($exercise_history_table, $monthly_count, $total_count, $total_days) {
        return new StudyHistoryDto($exercise_history_table, $monthly_count, $total_count, $total_days);
    }

    public function getMonthlyCount() {
        return $this->monthlyCount;
    }

    public function getTotalCount() {
        return $this->totalCount;
    }

    public function getTotalDays() {
        return $this->totalDays;
    }

    public function getGraphData() {
        $data_list = [];
        foreach ($this->exerciseDateCountMap as $count) {
            $data_list[] = $count;
        }
        return [
            "datasets" => [
                "data" => $data_list,
                "label" => "学習履歴",
                "backgroundColor" => "#f87979"
            ],
            "labels" => $this->labels
        ];
    }
}
