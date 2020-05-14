<?php

namespace Tests\Unit\usecase;

use App\Usecase\WorkbookUsecase;
use App\Domain\Workbook;
use Tests\TestCase;

use \Mockery as m;

class AnswerHistoryUsecaseTest extends TestCase
{
    protected $workbookEntityMock;

    protected $exerciseEntityMock;

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
        self::assertTrue(true);
    }

    public function testGetAnswerHistoryForWorkbook()
    {
        self::assertTrue(true);
    }
}
