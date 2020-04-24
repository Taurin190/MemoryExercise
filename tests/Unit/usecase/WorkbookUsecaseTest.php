<?php

namespace Tests\Unit\usecase;

use App\Usecase\WorkbookUsecase;
use Tests\TestCase;

use \Mockery as m;

class WorkbookUsecaseTest extends TestCase
{
    protected $workbookEntityMock;

    protected $workbookRepositoryMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->workbookEntityMock = m::mock('\App\Domain\Workbook');
        $this->workbookRepositoryMock = m::mock('\App\Domain\WorkbookRepository');
    }

    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }

    public function testCreateWorkbook()
    {
        $this->workbookRepositoryMock->shouldReceive('add')->with("test workbook", "This is test workbook.")->once()->andReturn(1);

        $workbook = new WorkbookUsecase($this->workbookRepositoryMock);
        $actual = $workbook->createWorkbook("test workbook", "This is test workbook.");
        self::assertSame($actual, 1);
    }

    public function testModifyWorkbook()
    {
        $this->workbookRepositoryMock->shouldReceive('modify')->with(1, "test workbook", "This is test workbook.")->once()->andReturn(1);

        $workbook = new WorkbookUsecase($this->workbookRepositoryMock);
        $actual = $workbook->modifyWorkbook(1, "test workbook", "This is test workbook.");
        self::assertSame($actual, 1);
    }
}
