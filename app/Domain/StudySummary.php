<?php


namespace App\Domain;


use App\Dto\StudySummaryDto;
use DateTime;

class StudySummary
{
    private $exerciseCountInMonth;

    private $totalExerciseCount;

    private $totalStudyDays;

    private $dateExerciseCountMap = [];

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
            if ($parameters['start_date'] instanceof DateTime) {
                $startDate = $parameters['start_date'];
            } else {
                throw new DomainException('Dateの型が正しくありません。');
            }
        }
        $endDate = new DateTime('last day of this month');
        if (isset($parameters['end_date'])) {
            if ($parameters['end_date'] instanceof DateTime) {
                $endDate = $parameters['end_date'];
            } else {
                throw new DomainException('Dateの型が正しくありません。');
            }
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
        }
    }

    public static function create($parameters)
    {
        return new StudySummary($parameters);
    }

    public static function createFromRepository($parameters)
    {
        $dateExerciseCountOrmList = [];
        if (isset($parameters['date_exercise_count_orm'])) {
            $dateExerciseCountOrmList = $parameters['date_exercise_count_orm'];
        }
        $dateExerciseCountMap = [];
        foreach ($dateExerciseCountOrmList as $dateExerciseCountOrm) {
            $dateExerciseCountMap[$dateExerciseCountOrm->Date] = (int)$dateExerciseCountOrm->days;
        }
        $parameters['date_exercise_count_map'] = $dateExerciseCountMap;

        return new StudySummary($parameters);
    }

    public function getDto()
    {
        return new StudySummaryDto(
            $this->exerciseCountInMonth,
            $this->totalExerciseCount,
            $this->totalStudyDays,
            $this->dateExerciseCountMap
        );
    }
}
