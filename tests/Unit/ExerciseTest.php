<?php

namespace Tests\Unit;

use App\Dto\ExerciseDto;
use Tests\TestCase;
use \App\Exercise;

use \Mockery as m;

class ExerciseTest extends TestCase
{
    protected $exerciseDomainMock;

    protected $exerciseDtoMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->exerciseDomainMock = m::mock('alias:\App\Domain\Exercise');
        $this->exerciseDtoMock = m::mock('alias:\App\Dto\ExerciseDto');
    }
    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }
    public function testPrimaryKey()
    {
        $workbook = new Exercise();
        $actual = $workbook->getKeyName();
        self::assertSame("exercise_id", $actual);
        $actual = $workbook->getKeyType();
        self::assertSame('string', $actual);
    }

    public function testFillable()
    {
        $workbook = new Exercise();
        $actual = $workbook->getFillable();
        self::assertSame(['question', 'answer', 'permission', 'author_id'], $actual);
    }

    public function testConvertOrmWithNewDomainModel()
    {
        $this->exerciseDomainMock
            ->shouldReceive('getExerciseDto')
            ->once()
            ->andReturn($this->exerciseDtoMock);
        $this->exerciseDtoMock
            ->shouldReceive('toArray')
            ->once()
            ->andReturn([
                'question' => 'Is this a pencil?',
                'answer' => 'Yes. it is.',
                'permission' => 1,
                'label_list' => []
            ]);
        $actual = Exercise::convertOrm($this->exerciseDomainMock);
        self::assertSame('Is this a pencil?', $actual->getAttribute('question'));
        self::assertSame('Yes. it is.', $actual->getAttribute('answer'));
    }
}
