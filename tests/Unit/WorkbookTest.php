<?php

namespace Tests\Unit;

use Tests\TestCase;
use \App\Workbook;

class WorkbookTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testPrimaryKey()
    {
        $workbook = new Workbook();
        $actual = $workbook->getKeyName();
        $this->assertSame("workbook_id", $actual);
        $actual = $workbook->getKeyType();
        $this->assertSame('string', $actual);
    }

    public function testFillable()
    {
        $workbook = new Workbook();
        $actual = $workbook->getFillable();
        $this->assertSame(['title', 'explanation', 'public'], $actual);
    }
}
