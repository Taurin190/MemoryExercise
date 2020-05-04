<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkbookControllerTest extends TestCase
{

    public function testList()
    {
        $response = $this->get(route('workbook.list'));
        $this->assertTrue(true);
    }
}
