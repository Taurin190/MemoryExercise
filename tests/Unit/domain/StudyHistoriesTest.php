<?php


namespace Tests\Unit\domain;


use App\Domain\DomainException;
use App\Domain\StudyHistories;
use Tests\TestCase;

class StudyHistoriesTest extends TestCase
{
    public function testCreate()
    {
        $actual = StudyHistories::createFromArray([
            'study_id' => 1,
            'user_id' => 10,
            'workbook_id' => 'workbook1',
            'exercise_study_map' => [
                'exercise1' => 1,
                'exercise2' => 2,
                'exercise3' => 3
            ]
        ]);
        self::assertTrue($actual instanceof StudyHistories);
    }

    public function testCreateWithoutUserId()
    {
        try {
            StudyHistories::createFromArray([
                'study_id' => 1,
                'workbook_id' => 'workbook1',
                'exercise_study_map' => [
                    'exercise1' => 1,
                    'exercise2' => 2,
                    'exercise3' => 3
                ]
            ]);
            fail('createFromArray didn\'t raise correct Exception');
        } catch (DomainException $e) {
            self::assertSame('user_idが設定されていません。', $e->getMessage());
        }
    }

    public function testCreateWithoutWorkbookId()
    {
        try {
            StudyHistories::createFromArray([
                'study_id' => 1,
                'user_id' => 10,
                'exercise_study_map' => [
                    'exercise1' => 1,
                    'exercise2' => 2,
                    'exercise3' => 3
                ]
            ]);
            fail('createFromArray didn\'t raise correct Exception');
        } catch (DomainException $e) {
            self::assertSame('workbook_idが設定されていません。', $e->getMessage());
        }
    }

    public function testCreateWithoutExerciseStudyMap()
    {
        try {
            StudyHistories::createFromArray([
                'study_id' => 1,
                'user_id' => 10,
                'workbook_id' => 'workbook1',
            ]);
            fail('createFromArray didn\'t raise correct Exception');
        } catch (DomainException $e) {
            self::assertSame('exercise_study_mapが設定されていません。', $e->getMessage());
        }
    }

    public function testToRecords()
    {
        $studyHistories = StudyHistories::createFromArray([
            'study_id' => 1,
            'user_id' => 10,
            'workbook_id' => 'workbook1',
            'exercise_study_map' => [
                'exercise1' => 1,
                'exercise2' => 2,
                'exercise3' => 3
            ]
        ]);
        $actual = $studyHistories->toRecords();
        self::assertSame(3, count($actual));
        $expected = [
            'study_id' => 1,
            'workbook_id' => 'workbook1',
            'exercise_id' => 'exercise1',
            'user_id' => 10,
            'score' => 1
        ];
        self::assertSame(1, $actual[0]['study_id']);
        self::assertSame('workbook1', $actual[0]['workbook_id']);
        self::assertSame('exercise1', $actual[0]['exercise_id']);
        self::assertSame(10, $actual[0]['user_id']);
        self::assertSame(1, $actual[0]['score']);
    }
}
