<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/09/02
 * Time: 17:58
 */

namespace App\Domain;


class ExerciseDailyTable
{
    private $daily_count_table;

    private $label_list;

    public function __construct($date_start, $date_end)
    {
        $this->daily_count_table = [];
        $this->label_list = [];
        for ($i = $date_start; $i <= $date_end; $i->modify('+1 day')){
            $this->daily_count_table[$i->format('Y-m-d')] = 0;
            $this->label_list[] = $i->format('Y-m-d');
        }
    }

    public function addCount(\App\ExerciseHistory $exerciseHistory)
    {
        $this->daily_count_table[$exerciseHistory->getAttribute('date')] = $exerciseHistory->getAttribute('count');
    }

    public function getDailyCountTable() {
        return $this->daily_count_table;
    }

    public function getDateLabelList() {
        return $this->label_list;
    }
}
