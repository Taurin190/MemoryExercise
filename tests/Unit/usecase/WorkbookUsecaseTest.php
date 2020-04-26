<?php

namespace Tests\Unit\usecase;

use App\Usecase\WorkbookUsecase;
use App\Domain\Workbook;
use Tests\TestCase;

use \Mockery as m;

class WorkbookUsecaseTest extends TestCase
{
    protected $workbookEntityMock;

    protected $exerciseEntityMock;

    protected $workbookRepositoryMock;

    protected $exerciseRepositoryMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->workbookEntityMock = m::mock('alias:\App\Domain\Workbook');
        $this->exerciseEntityMock = m::mock('\App\Domain\Exercise');
        $this->workbookRepositoryMock = m::mock('\App\Domain\WorkbookRepository');
        $this->exerciseRepositoryMock = m::mock('\App\Domain\ExerciseRepository');
    }

    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }

    public function testGetWorkbook()
    {
        $this->workbookRepositoryMock->shouldReceive('findByWorkbookId')->with(1)->once()->andReturn($this->workbookEntityMock);

        $workbook = new WorkbookUsecase($this->workbookRepositoryMock, $this->exerciseRepositoryMock);
        $actual = $workbook->getWorkbook(1);
        self::assertTrue($actual instanceof Workbook);
    }

    public function testGetAllWorkbook()
    {
        $workbookList = [$this->workbookEntityMock];
        $this->workbookRepositoryMock->shouldReceive('findAll')->once()->andReturn($workbookList);

        $workbook = new WorkbookUsecase($this->workbookRepositoryMock, $this->exerciseRepositoryMock);
        $actual = $workbook->getAllWorkbook();
        self::assertIsArray($actual);
        self::assertTrue($actual[0] instanceof Workbook);
    }

    public function testCreateWorkbook()
    {
        $this->workbookEntityMock
            ->shouldReceive('create')
            ->with("test workbook", "This is test workbook.")
            ->once()->andReturn($this->workbookEntityMock);
        $this->workbookRepositoryMock
            ->shouldReceive('save')
            ->with($this->workbookEntityMock)
            ->once()->andReturn();

        $workbook = new WorkbookUsecase($this->workbookRepositoryMock, $this->exerciseRepositoryMock);
        $workbook->createWorkbook("test workbook", "This is test workbook.");
    }

    public function testCreateWorkbookWithEmptyDescription()
    {
        $this->workbookEntityMock
            ->shouldReceive('create')
            ->with("test workbook", "")
            ->once()->andReturn($this->workbookEntityMock);
        $this->workbookRepositoryMock
            ->shouldReceive('save')
            ->with($this->workbookEntityMock)
            ->once()->andReturn();
        $workbook = new WorkbookUsecase($this->workbookRepositoryMock, $this->exerciseRepositoryMock);
        $workbook->createWorkbook("test workbook", "");
    }

    public function testModifyWorkbook()
    {
        $this->workbookRepositoryMock->shouldReceive('modify')->with(1, "test workbook", "This is test workbook.")->once()->andReturn(1);

        $workbook = new WorkbookUsecase($this->workbookRepositoryMock, $this->exerciseRepositoryMock);
        $actual = $workbook->modifyWorkbook(1, "test workbook", "This is test workbook.");
        self::assertSame(1, $actual);
    }

    public function testDeleteWorkbook()
    {
        $this->workbookRepositoryMock->shouldReceive('delete')->with(1)->once()->andReturn();

        $workbook = new WorkbookUsecase($this->workbookRepositoryMock, $this->exerciseRepositoryMock);
        $workbook->deleteWorkbook(1);
    }

    public function testAddExercise()
    {
        $this->workbookRepositoryMock
            ->shouldReceive('findByWorkbookId')
            ->with(1)
            ->once()->andReturn($this->workbookEntityMock);
        $this->exerciseRepositoryMock
            ->shouldReceive('findByExerciseId')
            ->with(1)
            ->once()->andReturn($this->exerciseEntityMock);
        $this->workbookEntityMock
            ->shouldReceive('addExercise')
            ->with($this->exerciseEntityMock)
            ->once()->andReturn($this->workbookEntityMock);
        $this->workbookRepositoryMock
            ->shouldReceive('save')
            ->with($this->workbookEntityMock)
            ->once()->andReturn();

        $workbook = new WorkbookUsecase($this->workbookRepositoryMock, $this->exerciseRepositoryMock);
        $workbook->addExercise(1, 1);
    }

    public function testDeleteExercise()
    {
        $this->workbookRepositoryMock
            ->shouldReceive('findByWorkbookId')
            ->with(1)
            ->once()->andReturn($this->workbookEntityMock);
        $this->exerciseRepositoryMock
            ->shouldReceive('findByExerciseId')
            ->with(1)
            ->once()->andReturn($this->exerciseEntityMock);
        $this->workbookEntityMock
            ->shouldReceive('deleteExercise')
            ->with($this->exerciseEntityMock)
            ->once()->andReturn($this->workbookEntityMock);
        $this->workbookRepositoryMock
            ->shouldReceive('save')
            ->with($this->workbookEntityMock)
            ->once()->andReturn();

        $workbook = new WorkbookUsecase($this->workbookRepositoryMock, $this->exerciseRepositoryMock);
        $workbook->deleteExercise(1, 1);
    }

    public function testModifyExerciseOrder()
    {
        $this->workbookRepositoryMock
            ->shouldReceive('findByWorkbookId')
            ->with(1)
            ->once()->andReturn($this->workbookEntityMock);
        $this->exerciseRepositoryMock
            ->shouldReceive('findByExerciseId')
            ->with(1)
            ->once()->andReturn($this->exerciseEntityMock);
        $this->workbookEntityMock
            ->shouldReceive('modifyOrder')
            ->with($this->exerciseEntityMock, 3)
            ->once()->andReturn($this->workbookEntityMock);
        $this->workbookRepositoryMock
            ->shouldReceive('save')
            ->with($this->workbookEntityMock)
            ->once()->andReturn();

        $workbook = new WorkbookUsecase($this->workbookRepositoryMock, $this->exerciseRepositoryMock);
        $workbook->modifyExerciseOrder(1,1, 3);
    }
}
