<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/08/24
 * Time: 16:44
 */

namespace App\Dto;


use DateTime;

class ExerciseCountDto
{
    private $exerciseDateCountMap;

    private $labels = [];

    private $totalCount;

    private function __construct($labels, $exerciseDateCountMap, $totalCount)
    {
        $this->labels = $labels;
        $this->exerciseDateCountMap = $exerciseDateCountMap;
        $this->totalCount = $totalCount;
    }

    public static function map($exercise_history_list) {
        $exercise_date_count_map = [];
        $date_start = (new DateTime())->modify('-1 month');
        $date_end = new DateTime();
        $labels = [];
        $total_count = 0;
        for ($i = $date_start; $i <= $date_end; $i->modify('+1 day')){
            $exercise_date_count_map[$i->format('Y-m-d')] = 0;
            $labels[] = $i->format('Y-m-d');
        }
        foreach ($exercise_history_list as $exercise_history) {
            $history_date = $exercise_history->getCreatedAt();
            if (array_key_exists($history_date, $exercise_date_count_map)) {
                $exercise_date_count_map[$history_date] += 1;
                $total_count += 1;
            } else {
                $exercise_date_count_map[$history_date] = 1;
                $total_count += 1;
            }
        }
        return new ExerciseCountDto($labels, $exercise_date_count_map, $total_count);
    }

    public function getTotalCount() {
        return $this->totalCount;
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
