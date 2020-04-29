<?php

namespace Tests\Unit\domain;

use App\Exceptions\DataNotFoundException;
use App\Infrastructure\ExerciseRepository;
use Tests\TestCase;
use \Mockery as m;

class ExerciseRepositoryTest extends TestCase
{
    protected $exerciseMock;

    protected $exerciseDomainMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->exerciseMock = m::mock('alias:\App\Domain\Exercise');
        $this->exerciseDomainMock = m::mock('alias:\App\Exercise');
    }

    public function testFindByExerciseId()
    {
        $this->exerciseDomainMock
            ->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn($this->exerciseDomainMock);
        $this->exerciseDomainMock
            ->shouldReceive('first')
            ->once()
            ->andReturn($this->exerciseDomainMock);
        $this->exerciseMock
            ->shouldReceive('map')
            ->once()
            ->with($this->exerciseDomainMock)
            ->andReturn($this->exerciseMock);
        $repository = new ExerciseRepository();
        $domain = $repository->findByExerciseId(1);
        self::assertTrue($domain instanceof \App\Domain\Exercise);
    }
    public function testFindByExerciseIdNotFound()
    {
        $this->exerciseDomainMock
            ->shouldReceive('find')
            ->once()
            ->with(999)
            ->andReturn();
        $repository = new ExerciseRepository();
        try {
            $repository->findByExerciseId(999);
            self::fail("例外が発生しませんでした。");
        } catch (DataNotFoundException $e) {
            self::assertSame("Data not found in exercises by id: 999", $e->getMessage());
        }
    }
}
