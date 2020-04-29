<?php

namespace Tests\Unit;

use Tests\TestCase;
use \App\Exercise;

use \Mockery as m;

class ExerciseTest extends TestCase
{
    protected $exerciseDomainMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->exerciseDomainMock = m::mock('alias:\App\Domain\Exercise');
    }

    public function testPrimaryKey()
    {
        $workbook = new Exercise();
        $actual = $workbook->getKeyName();
        self::assertSame("exercise_id", $actual);
        $actual = $workbook->getKeyType();
        self::assertSame('int', $actual);
    }

    public function testFillable()
    {
        $workbook = new Exercise();
        $actual = $workbook->getFillable();
        self::assertSame(['question', 'answer'], $actual);
    }

    public function testMap()
    {
        $this->exerciseDomainMock
            ->shouldReceive('getExerciseId')
            ->once()
            ->andReturn(1);
        $this->exerciseDomainMock
            ->shouldReceive('getQuestion')
            ->once()
            ->andReturn('Is this a pencil?');
        $this->exerciseDomainMock
            ->shouldReceive('getAnswer')
            ->once()
            ->andReturn('Yes. it is.');
        $actual = Exercise::map($this->exerciseDomainMock);
        self::assertSame(1, $actual->getKey());
        self::assertSame('Is this a pencil?', $actual->getAttribute('question'));
        self::assertSame('Yes. it is.', $actual->getAttribute('answer'));
    }
}
