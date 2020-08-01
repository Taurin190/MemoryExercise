<?php

namespace Tests\Unit\usecase;

use App\Usecase\AnswerHistoryUsecase;
use App\Domain\Answer;
use App\Domain\AnswerHistory;
use Tests\TestCase;

use \Mockery as m;

class AnswerHistoryUsecaseTest extends TestCase
{
    protected $answerMock;

    protected $workbookMock;

    protected $answerHistoryMock;

    protected $answerHistoryRepositoryMock;

    protected $exerciseRepositoryMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->answerMock = m::mock('alias:\App\Domain\Answer');
        $this->workbookMock = m::mock('alias:\App\Domain\Workbook');
        $this->answerHistoryMock = m::mock('alias:\App\Domain\AnswerHistory');
        $this->answerHistoryRepositoryMock = m::mock('\App\Domain\AnswerHistoryRepository');

    }

    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }

    public function testAddAnswerHistory()
    {
        $this->answerHistoryMock
            ->shouldReceive('create')
            ->with($this->answerMock, $this->workbookMock, 1)
            ->once()
            ->andReturn($this->answerHistoryMock);
        $this->answerHistoryRepositoryMock
            ->shouldReceive('save')
            ->with($this->answerHistoryMock)
            ->once()
            ->andReturn();
        $answer_history = new AnswerHistoryUsecase($this->answerHistoryRepositoryMock);
        $answer_history->addAnswerHistory($this->answerMock, $this->workbookMock, 1);
        self::assertTrue(true);
    }

    public function testGetAnswerHistoryForWorkbook()
    {
        self::assertTrue(true);
    }
}
