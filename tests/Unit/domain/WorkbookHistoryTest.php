<?php

namespace Tests\Unit\domain;

use App\Domain\WorkbookDomainException;
use Tests\TestCase;
use App\Domain\WorkbookHistory;
use \Mockery as m;

class WorkbookHistoryTest extends TestCase
{
    protected $answerMock;

    protected $workbookMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->answerMock = m::mock('\App\Domain\Answer');
        $this->workbookMock = m::mock('alias:App\Domain\Workbook');
    }
    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }
    public function testMap() {
        $this->answerMock->shouldReceive('getExerciseCount')
            ->once()->andReturn();
        $this->answerMock->shouldReceive('getOKCount')
            ->once()->andReturn();
        $this->answerMock->shouldReceive('getNGCount')
            ->once()->andReturn();
        $this->answerMock->shouldReceive('getStudyingCount')
            ->once()->andReturn();
        WorkbookHistory::map($this->answerMock, $this->workbookMock);
        self::assertTrue(true);
    }
}
