<?php

namespace Tests\Unit;

use Tests\TestCase;
use \App\Exercise;

class ExerciseTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testPrimaryKey()
    {
        $workbook = new Exercise();
        $actual = $workbook->getKeyName();
        $this->assertSame("exercise_id", $actual);
        $actual = $workbook->getKeyType();
        $this->assertSame('int', $actual);
    }

    public function testFillable()
    {
        $workbook = new Exercise();
        $actual = $workbook->getFillable();
        $this->assertSame(['question', 'answer'], $actual);
    }
}
