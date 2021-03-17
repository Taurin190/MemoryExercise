<?php

namespace Tests\Unit\domain;

use App\Domain\WorkbookDomainException;
use Tests\TestCase;
use App\Domain\Workbook;
use \Mockery as m;

class WorkbookTest extends TestCase
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
    public function testCreate() {
        try {
            $workbook = Workbook::create(['title' => "test workbook", 'explanation' => "This is an example of workbook."]);
            self::assertTrue($workbook instanceof Workbook);
            $actual = $workbook->getTitle();
            self::assertSame("test workbook", $actual);
            $actual = $workbook->getExplanation();
            self::assertSame("This is an example of workbook.", $actual);
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。");
        }
    }
}
