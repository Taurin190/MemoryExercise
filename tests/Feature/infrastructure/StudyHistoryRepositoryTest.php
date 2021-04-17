<?php

namespace Tests\Feature\infrastructure;

use App\Domain\StudyHistories;
use App\Infrastructure\StudyHistoryRepository;
use App\StudyHistory;
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
}
