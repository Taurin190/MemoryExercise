<?php

namespace Tests\Unit\domain;

use App\Domain\Workbooks;
use App\Dto\WorkbookDto;
use Mockery as m;
use Tests\TestCase;

class WorkbooksTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }

    public function testConvertByOrmList()
    {
        $workbook_orm_list = factory(\App\Workbook::class, 10)->make();
        $workbooks = Workbooks::convertByOrmList($workbook_orm_list);
        self::assertTrue($workbooks instanceof Workbooks);
        self::assertSame(10, $workbooks->count());
    }

    public function testGetWorkbookDtoList()
    {
        $workbook_orm_list = factory(\App\Workbook::class, 10)->make();
        $workbooks = Workbooks::convertByOrmList($workbook_orm_list);
        $actual = $workbooks->getWorkbookDtoList();
        self::assertTrue(is_array($actual));
        self::assertTrue($actual[0] instanceof WorkbookDto);
    }

    public function testCount()
    {
        $workbook_orm_list = factory(\App\Workbook::class, 15)->make();
        $workbooks = Workbooks::convertByOrmList($workbook_orm_list);
        $actual = $workbooks->count();
        self::assertSame(15, $actual);
    }
}
