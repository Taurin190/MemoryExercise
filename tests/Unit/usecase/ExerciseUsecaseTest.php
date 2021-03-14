<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/05/21
 * Time: 6:33
 */

namespace Tests\Unit\usecase;
use App\Dto\ExerciseDto;
use Tests\TestCase;
use App\Domain\Exercise;
use App\Http\Requests\ExerciseFormRequest;
use App\Infrastructure\ExerciseRepository;
use App\Usecase\ExerciseUsecase;

use \Mockery as m;

class ExerciseUsecaseTest extends TestCase
{
    protected $exerciseDomain;

    protected $exerciseRequest;

    protected $exerciseRepository;

    protected $exerciseDto;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->exerciseDomain = m::mock('alias:App\Domain\Exercise');
        $this->exerciseRequest = m::mock('App\Http\Requests\ExerciseFormRequest');
        $this->exerciseRepository = m::mock('App\Infrastructure\ExerciseRepository');
        $this->exerciseDto = m::mock('App\Dto\ExerciseDto');
        $this->user = m::mock('App\User');
    }
    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }

    public function testMakeExercise() {
        $this->exerciseDomain
            ->shouldReceive('create')
            ->with(['question' => 'How are you?', 'answer' =>'I\'m fine. thank you.', 'permission' => 1, 'author_id' => 1])
            ->once()->andReturn($this->exerciseDomain);
        $exercise_usecase = new ExerciseUsecase($this->exerciseRepository);
        $actual = $exercise_usecase->makeExercise('How are you?','I\'m fine. thank you.', 1, 1);
        self::assertTrue($actual instanceof Exercise);
    }

    public function testSearchExercise() {
        $exercise_mock1 = m::mock('alias:App\Domain\Exercise');
        $exercise_mock2 = m::mock('alias:App\Domain\Exercise');
        $exercise_mock3 = m::mock('alias:App\Domain\Exercise');
        $exercise_usecase = new ExerciseUsecase($this->exerciseRepository);
        $this->exerciseRepository->shouldReceive('searchCount')->with("ab")->once()->andReturn(3);
        $this->exerciseRepository->shouldReceive('search')->with("ab", 1)->once()->andReturn([
            $exercise_mock1,
            $exercise_mock2,
            $exercise_mock3
        ]);
        $actual = $exercise_usecase->searchExercise("ab", 1);
        self::assertSame([
            'count' => 3,
            'exercise_list' => [
                $exercise_mock1,
                $exercise_mock2,
                $exercise_mock3
            ],
            'page' => 1
        ], $actual);
    }

    public function testSearchExerciseWithoutText() {
        $exercise_mock1 = m::mock('alias:App\Domain\Exercise');
        $exercise_mock2 = m::mock('alias:App\Domain\Exercise');
        $exercise_mock3 = m::mock('alias:App\Domain\Exercise');
        $exercise_usecase = new ExerciseUsecase($this->exerciseRepository);
        $this->exerciseRepository->shouldReceive('count')->with(null)->once()->andReturn(3);
        $this->exerciseRepository->shouldReceive('findAll')->with(10, null, 1)->once()->andReturn([
            $exercise_mock1,
            $exercise_mock2,
            $exercise_mock3
        ]);
        $actual = $exercise_usecase->searchExercise("", 1);
        self::assertSame([
            'count' => 3,
            'exercise_list' => [
                $exercise_mock1,
                $exercise_mock2,
                $exercise_mock3
            ],
            'page' => 1
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

    public function testDeleteExercise() {
        $this->exerciseRepository->shouldReceive('checkEditPermission')->with('test', 1)->once()->andReturn(true);
        $this->exerciseRepository->shouldReceive('delete')->with('test')->once()->andReturn();
        $exercise_usecase = new ExerciseUsecase($this->exerciseRepository);
        $exercise_usecase->deleteExercise('test', 1);
    }

    public function testRegisterExercise() {
        $this->exerciseDto->question = 'Is this dog?';
        $this->exerciseDto->answer = 'Is this dog?';
        $this->exerciseDto->permission = 1;
        $this->exerciseDto->label = ['animal', 'dog'];
        $this->exerciseDomain->shouldReceive('createFromDto')->with($this->exerciseDto)->once()->andReturn($this->exerciseDomain);
        $this->exerciseRepository->shouldReceive('save')->with($this->exerciseDomain)->once()->andReturn();
        $exercise_usecase = new ExerciseUsecase($this->exerciseRepository);
        $exercise_usecase->registerExercise($this->exerciseDto, 1);
    }

    public function testGetExerciseDtoById() {
        $this->exerciseRepository->shouldReceive('findByExerciseId')->with('test1', 1)->once()->andReturn($this->exerciseDomain);
        $this->exerciseDomain->shouldReceive('getExerciseDto')->with()->once()->andReturn($this->exerciseDto);
        $exercise_usecase = new ExerciseUsecase($this->exerciseRepository);
        $actual = $exercise_usecase->getExerciseDtoById('test1', 1);
        self::assertTrue($actual instanceof ExerciseDto);
    }
}
