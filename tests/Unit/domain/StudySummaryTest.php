<?php


namespace Tests\Unit\domain;


use App\Domain\StudySummary;
use Tests\TestCase;

class StudySummaryTest extends TestCase
{
    public function testCreateStudySummary()
    {
        $studySummary = StudySummary::create([
            'exercise_count_in_month' => 10,
            'total_exercise_count' => 20,
            'total_study_days' => 5,
            'date_exercise_count_map' => []
        ]);
        $actual = $studySummary->getDto();
        self::assertSame(10, $actual->exerciseCountInMonth);
        self::assertSame(20, $actual->totalExerciseCount);
        self::assertSame(5, $actual->totalStudyDays);
    }

    public function testCreateStudySummaryWithGraphData()
    {
        $studySummary = StudySummary::create([
            'exercise_count_in_month' => 10,
            'total_exercise_count' => 20,
            'total_study_days' => 5,
            'date_exercise_count_map' => [],
            'start_date' => '2020-01-01',
            'end_date' => '2020-01-03',
        ]);
        $actual = $studySummary->getDto();
        $expected = [
            "datasets" => [
                "data" => [
                    '2020-01-01' => 0,
                    '2020-01-02' => 0,
                    '2020-01-03' => 0,
                ],
                "label" => "学習履歴",
                "backgroundColor" => "#f87979"
            ],
            "labels" => [
                '1/1',
                '1/2',
                '1/3'
            ]
        ];

        self::assertSame($expected, $actual->graphData);
    }
}
