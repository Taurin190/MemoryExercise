<?php
namespace Tests\Unit\infrastructure;
use \App\Infrastructure\WorkbookRepository;
use Tests\TestCase;
use \Mockery as m;

class WorkbookRepositoryTest extends TestCase
{
    protected $workbookDomainMock;
    protected $workbookMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->workbookDomainMock = m::mock('alias:\App\Domain\Workbook');
        $this->workbookMock = m::mock('alias:\App\Workbook');
    }
    public function testFindByWorkbookId()
    {
        $this->workbookMock
            ->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn($this->workbookMock);
        $this->workbookMock
            ->shouldReceive('first')
            ->once()
            ->andReturn($this->workbookMock);
        $this->workbookDomainMock
            ->shouldReceive('map')
            ->once()
            ->with($this->workbookMock)
            ->andReturn($this->workbookDomainMock);
        $repository = new WorkbookRepository();
        $domain = $repository->findByWorkbookId(1);
        self::assertTrue($domain instanceof \App\Domain\Workbook);
    }

    public function testFindAll()
    {
        $this->workbookMock
            ->shouldReceive('all')
            ->once()
            ->andReturn([$this->workbookMock]);
        $this->workbookDomainMock
            ->shouldReceive('map')
            ->once()
            ->with($this->workbookMock)
            ->andReturn($this->workbookDomainMock);
        $repository = new WorkbookRepository();
        $actual = $repository->findAll();
        self::assertTrue(is_array($actual));
        self::assertSame(1, count($actual));
    }

    public function testSave()
    {
        $this->workbookMock
            ->shouldReceive('map')
            ->once()
            ->with($this->workbookDomainMock)
            ->andReturn($this->workbookMock);
        $this->workbookMock
            ->shouldReceive('save')
            ->once()
            ->andReturn();
        $repository = new WorkbookRepository();
        $repository->save($this->workbookDomainMock);
    }

    public function testDelete()
    {
        $this->workbookMock
            ->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn($this->workbookMock);
        $this->workbookMock
            ->shouldReceive('delete')
            ->once()
            ->andReturn($this->workbookMock);
        $repository = new WorkbookRepository();
        $repository->delete(1);
    }
}
