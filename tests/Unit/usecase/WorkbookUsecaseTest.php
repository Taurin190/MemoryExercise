<?php

namespace Tests\Unit\usecase;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        $this->assertTrue(true);
    }
}
