<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Usecase\WorkbookUsecase;

use \Mockery as m;

class WorkbookControllerTest extends TestCase
{

    public function testList()
    {
        $workbookUsecaseMock = m::mock('App\Usecase\WorkbookUsecase');
        $workbookUsecaseMock->shouldReceive('getAllWorkbook')
            ->once()
            ->andReturn([]);
        $this->instance(WorkbookUsecase::class, $workbookUsecaseMock);
        $response = $this->get(route('workbook.list'));
        $response->assertViewIs('workbook_list');
        $response->assertViewHas('workbooks');
        self::assertSame([], $response->viewData('workbooks'));
    }
}
