<?php

namespace Tests\Unit\usecase;

use App\Usecase\AnswerHistoryUsecase;
use App\Domain\Answer;
use App\Domain\ExerciseHistory;
use Tests\TestCase;

use \Mockery as m;

class AnswerHistoryUsecaseTest extends TestCase
{
    protected $AnswerHistoryMock;

    protected $AnswerMock;

    protected $workbookRepositoryMock;

    protected $exerciseRepositoryMock;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }

    public function testAddAnswerHistory()
    {
        $answer_history = new AnswerHistoryUsecase();

        self::assertTrue(true);
    }

    public function testGetAnswerHistoryForWorkbook()
    {
        self::assertTrue(true);
    }
}
