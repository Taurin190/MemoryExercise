<?php


namespace Tests\Unit\usecase;

use App\Dto\StudySummaryDto;
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

    public function testGetStudySummary()
    {
        $studySummary = m::mock('\App\Domain\StudySummary');
        $studySummary
            ->shouldReceive('getDto')
            ->once()
            ->andReturn(new StudySummaryDto(10, 10, 3, []));
        $studyHistoryRepository = m::mock('\App\Domain\StudyHistoryRepository');
        $studyHistoryRepository
            ->shouldReceive('inquireStudySummary')
            ->once()
            ->andReturn($studySummary);
        $studyHistoryUsecase = new StudyHistoryUsecase($studyHistoryRepository);
        $actual = $studyHistoryUsecase->getStudySummary(15);
        self::assertTrue($actual instanceof StudySummaryDto);
    }
}
