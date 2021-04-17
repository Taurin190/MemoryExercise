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
        self::assertSame([], $actual->graphData);
    }
}
