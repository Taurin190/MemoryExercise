<?php

namespace Tests\Feature\infrastructure;

use App\Domain\StudyHistories;
use App\Domain\StudySummary;
use App\Infrastructure\StudyHistoryRepository;
use App\StudyHistory;
use DateTime;
use Tests\TestCase;

class StudyHistoryRepositoryTest extends TestCase
{
    public function testSave()
    {
        // delete records to go through path of no records
        StudyHistory::query()->delete();
        $studyHistories = StudyHistories::createFromArray([
            'user_id' => 10,
            'workbook_id' => 'test1',
            'exercise_study_map' => [
                'exercise1' => 1,
                'exercise2' => 2,
                'exercise3' => 3
            ]
        ]);
        $studyHistoryRepository = new StudyHistoryRepository();
        $studyHistoryRepository->save($studyHistories);
        $this->assertDatabaseHas('study_histories', [
            'user_id' => 10
        ]);
    }

    public function testInquireStudySummary()
    {
        factory(\App\StudyHistory::class)->create([
            'user_id' => 15,
            'workbook_id' => 'test1',
            'exercise_id' => 'exercise1',
            'created_at' => '2021-04-02 00:00:00'
        ]);
        factory(\App\StudyHistory::class)->create([
            'user_id' => 15,
            'workbook_id' => 'test1',
            'exercise_id' => 'exercise2',
            'created_at' => '2021-04-02 00:00:00'
        ]);
        factory(\App\StudyHistory::class)->create([
            'user_id' => 15,
            'workbook_id' => 'test1',
            'exercise_id' => 'exercise3',
            'created_at' => '2021-04-02 00:00:00'
        ]);
        $studyHistoryRepository = new StudyHistoryRepository();
        $actual = $studyHistoryRepository->inquireStudySummary(
            15,
            new DateTime('2021-04-01 00:00:00'),
            new DateTime('2021-04-03 00:00:00')
        );
        self::assertTrue($actual instanceof StudySummary);

        $dto = $actual->getDto();
        self::assertSame(3, $dto->exerciseCountInMonth);
        self::assertSame(3, $dto->totalExerciseCount);
        self::assertSame(1, $dto->totalStudyDays);
    }
}
