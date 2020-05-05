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
    public function testDetail()
    {
        $workbookUsecaseMock = m::mock('App\Usecase\WorkbookUsecase');
        $workbookDomainMock = m::mock('App\Domain\Workbook');
        $workbookUsecaseMock->shouldReceive('getWorkbook')
            ->once()
            ->with('testid1')
            ->andReturn($workbookDomainMock);
        $workbookDomainMock->shouldReceive('getTitle')
            ->andReturn('test workbook');
        $workbookDomainMock->shouldReceive('getExplanation')
            ->andReturn('this is test workbook');
        $this->instance(WorkbookUsecase::class, $workbookUsecaseMock);
        $response = $this->get(route('workbook.detail', 'testid1'));
        $response->assertViewIs('workbook_detail');
        $response->assertViewHas('workbook');
    }
}
