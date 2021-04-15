<?php


namespace Tests\Unit\domain;


use App\Domain\StudyHistory;
use Tests\TestCase;

class StudyHistoryTest extends TestCase
{
    public function testArrayAccess()
    {
        $studyHistory = StudyHistory::create('exercise1', 1);
        self::assertSame('exercise1', $studyHistory['exercise_id']);
        self::assertSame(1, $studyHistory['score']);
    }

    public function testArrayAccessWithInvalidProperties()
    {
        $studyHistory = StudyHistory::create('exercise1', 1);
        self::assertNull($studyHistory['invalid']);
    }

    public function testProtectFromControl()
    {
        $studyHistory = StudyHistory::create('exercise1', 1);
        $studyHistory['score'] = 2;
        unset($studyHistory['exercise_id']);
        self::assertSame(1, $studyHistory['score']);
        self::assertSame('exercise1', $studyHistory['exercise_id']);
    }
}
