<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/05/21
 * Time: 6:33
 */

namespace Tests\Unit\usecase;
use Tests\TestCase;
use App\Domain\Exercise;
use App\Http\Requests\ExerciseRequest;
use App\Infrastructure\ExerciseRepository;
use App\Usecase\ExerciseUsecase;

use \Mockery as m;

class ExerciseUsecaseTest extends TestCase
{
    protected $exerciseDomain;

    protected $exerciseRequest;

    protected $exerciseRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->exerciseDomain = m::mock('alias:App\Domain\Exercise');
        $this->exerciseRequest = m::mock('App\Http\Requests\ExerciseRequest');
        $this->exerciseRepository = m::mock('App\Infrastructure\ExerciseRepository');
    }
    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }

    public function testMakeExercise() {
        $this->exerciseDomain
            ->shouldReceive('create')
            ->with(['question' => 'How are you?', 'answer' =>'I\'m fine. thank you.', 'permission' => 1])
            ->once()->andReturn($this->exerciseDomain);
        $exercise_usecase = new ExerciseUsecase($this->exerciseRepository);
        $actual = $exercise_usecase->makeExercise('How are you?','I\'m fine. thank you.', 1);
        self::assertTrue($actual instanceof Exercise);
    }

    public function testCreateExercise() {
        $this->exerciseDomain
            ->shouldReceive('create')
            ->with(['question' => 'How are you?', 'answer' =>'I\'m fine. thank you.', 'permission' => 1])
            ->once()->andReturn($this->exerciseDomain);
        $this->exerciseRepository
            ->shouldReceive('save')
            ->with($this->exerciseDomain)
            ->once()->andReturn();
        $exercise_usecase = new ExerciseUsecase($this->exerciseRepository);
        $exercise_usecase->createExercise('How are you?','I\'m fine. thank you.', 1);
    }

    public function testSearchExercise() {
        $exercise_mock1 = m::mock('alias:App\Domain\Exercise');
        $exercise_mock2 = m::mock('alias:App\Domain\Exercise');
        $exercise_mock3 = m::mock('alias:App\Domain\Exercise');
        $exercise_usecase = new ExerciseUsecase($this->exerciseRepository);
        $this->exerciseRepository->shouldReceive('search')->with("ab", 1)->once()->andReturn([
                $exercise_mock1,
                $exercise_mock2,
                $exercise_mock3
        ]);
        $actual = $exercise_usecase->searchExercise("ab", 1);
        self::assertSame([
            $exercise_mock1,
            $exercise_mock2,
            $exercise_mock3
        ], $actual);
    }

    public function testSearchExerciseWithoutText() {
        $exercise_mock1 = m::mock('alias:App\Domain\Exercise');
        $exercise_mock2 = m::mock('alias:App\Domain\Exercise');
        $exercise_mock3 = m::mock('alias:App\Domain\Exercise');
        $exercise_usecase = new ExerciseUsecase($this->exerciseRepository);
        $this->exerciseRepository->shouldReceive('findAll')->with()->once()->andReturn([
            $exercise_mock1,
            $exercise_mock2,
            $exercise_mock3
        ]);
        $actual = $exercise_usecase->searchExercise("", 1);
        self::assertSame([
            $exercise_mock1,
            $exercise_mock2,
            $exercise_mock3
        ], $actual);
    }

    public function testGetAllExercisesWithIdList() {
        $exercise_mock1 = m::mock('alias:App\Domain\Exercise');
        $exercise_mock2 = m::mock('alias:App\Domain\Exercise');
        $exercise_mock3 = m::mock('alias:App\Domain\Exercise');
        $this->exerciseRepository->shouldReceive('findAllByExerciseIdList')->with(['aaa', 'bbb', 'ccc'])->once()->andReturn([
            $exercise_mock1,
            $exercise_mock2,
            $exercise_mock3
        ]);
        $exercise_usecase = new ExerciseUsecase($this->exerciseRepository);
        $actual = $exercise_usecase->getAllExercisesWithIdList(['aaa', 'bbb', 'ccc']);
        self::assertSame([
            $exercise_mock1,
            $exercise_mock2,
            $exercise_mock3
        ], $actual);
    }
}
