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

    protected $userMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->exerciseDomainMock = m::mock('alias:\App\Domain\Exercise');
        $this->exerciseMock = m::mock('alias:\App\Exercise');
        $this->userMock = m::mock('\App\User');
    }
    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }
    public function testFindByExerciseId()
    {
        $this->exerciseMock
            ->shouldReceive('where')
            ->once()
            ->with('exercise_id', "1")
            ->andReturn($this->exerciseMock);
        $this->exerciseMock
            ->shouldReceive('where')
            ->once()
            ->with('permission', "1")
            ->andReturn($this->exerciseMock);
        $this->exerciseMock
            ->shouldReceive('first')
            ->once()
            ->andReturn($this->exerciseMock);
        $this->exerciseDomainMock
            ->shouldReceive('map')
            ->once()
            ->with($this->exerciseMock)
            ->andReturn($this->exerciseDomainMock);
        $repository = new ExerciseRepository();
        $domain = $repository->findByExerciseId("1");
        self::assertTrue($domain instanceof \App\Domain\Exercise);
    }

    public function testFindByExerciseIdNotFound()
    {
        $this->exerciseMock
            ->shouldReceive('where')
            ->once()
            ->with('exercise_id', '999')
            ->andReturn($this->exerciseMock);
        $this->exerciseMock
            ->shouldReceive('where')
            ->once()
            ->with('permission', 1)
            ->andReturn();
        $repository = new ExerciseRepository();
        try {
            $repository->findByExerciseId('999');
            self::fail("例外が発生しませんでした。");
        } catch (DataNotFoundException $e) {
            self::assertSame("Data not found in exercises by id: 999", $e->getMessage());
        }
    }

    public function testSave()
    {
        $this->exerciseMock
            ->shouldReceive('map')
            ->once()
            ->with($this->exerciseDomainMock)
            ->andReturn($this->exerciseMock);
        $this->exerciseMock
            ->shouldReceive('save')
            ->once()
            ->andReturn();
        $repository = new ExerciseRepository();
        $repository->save($this->exerciseDomainMock);
    }
}
