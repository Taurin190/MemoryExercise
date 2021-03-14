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
            ->shouldReceive('convertDomain')
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
            ->shouldReceive('convertOrm')
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

    public function testFindAllByExerciseIdListWithoutUser()
    {
        $exerciseMock1 = m::mock('alias:\App\Exercise');
        $exerciseMock2 = m::mock('alias:\App\Exercise');
        $exerciseMock3 = m::mock('alias:\App\Exercise');
        $exerciseDomainMock1 = m::mock('alias:\App\Domain\Exercise');
        $exerciseDomainMock2 = m::mock('alias:\App\Domain\Exercise');
        $exerciseDomainMock3 = m::mock('alias:\App\Domain\Exercise');
        $this->exerciseMock
            ->shouldReceive('whereIn')
            ->once()
            ->with('exercise_id', ["test1", "test2", "test3"])
            ->andReturn($this->exerciseMock);
        $this->exerciseMock
            ->shouldReceive('where')
            ->once()
            ->with('permission', 1)
            ->andReturn($this->exerciseMock);
        $this->exerciseMock
            ->shouldReceive('get')
            ->once()
            ->with()
            ->andReturn([$exerciseMock1, $exerciseMock2, $exerciseMock3]);
        $this->exerciseDomainMock
            ->shouldReceive('convertDomain')
            ->once()
            ->with($exerciseMock1)
            ->andReturn($exerciseDomainMock1);
        $this->exerciseDomainMock
            ->shouldReceive('convertDomain')
            ->once()
            ->with($exerciseMock2)
            ->andReturn($exerciseDomainMock2);
        $this->exerciseDomainMock
            ->shouldReceive('convertDomain')
            ->once()
            ->with($exerciseMock3)
            ->andReturn($exerciseDomainMock3);
        $repository = new ExerciseRepository();
        $actual = $repository->findAllByExerciseIdList(["test1", "test2", "test3"]);
        self::assertSame(3, count($actual));
        self::assertTrue($actual[0] instanceof \App\Domain\Exercise);
        self::assertTrue($actual[1] instanceof \App\Domain\Exercise);
        self::assertTrue($actual[2] instanceof \App\Domain\Exercise);
    }
}
