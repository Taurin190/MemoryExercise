<?php

namespace Tests\Unit\domain;

use App\Domain\Workbooks;
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
}
