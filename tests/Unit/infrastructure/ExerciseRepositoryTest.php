<?php

namespace Tests\Unit\domain;

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
}
