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
    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }
    public function testFindByWorkbookId()
    {
        $this->workbookMock
            ->shouldReceive('where')
            ->once()
            ->with('workbook_id', 'test1')
            ->andReturn($this->workbookMock);
        $this->workbookMock
            ->shouldReceive('first')
            ->twice()
            ->andReturn($this->workbookMock);
        $this->workbookDomainMock
            ->shouldReceive('map')
            ->once()
            ->with($this->workbookMock)
            ->andReturn($this->workbookDomainMock);
        $repository = new WorkbookRepository();
        $domain = $repository->findByWorkbookId('test1');
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
            ->shouldReceive('where')
            ->once()
            ->with('workbook_id', '1')
            ->andReturn($this->workbookMock);
        $this->workbookMock
            ->shouldReceive('delete')
            ->once()
            ->andReturn($this->workbookMock);
        $repository = new WorkbookRepository();
        $repository->delete('1');
    }
}
