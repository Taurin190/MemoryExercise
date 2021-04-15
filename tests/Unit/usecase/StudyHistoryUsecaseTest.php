<?php


namespace Tests\Unit\usecase;

use App\Usecase\StudyHistoryUsecase;
use Mockery as m;
use Tests\TestCase;

class StudyHistoryUsecaseTest extends TestCase
{
    public function testSaveStudyHistory()
    {
        $studyHistoryRepository = m::mock('\App\Domain\StudyHistoryRepository');
        $studyHistoryRepository
            ->shouldReceive('save')
            ->once();
        $studyHistoryUsecase = new StudyHistoryUsecase($studyHistoryRepository);
        $studyHistoryUsecase->saveStudyHistory('workbook1', ['exercise1' => 1], 10);
    }
}
