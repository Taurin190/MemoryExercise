<?php

namespace Tests\Unit\usecase;

use App\Domain\Exercise;
use App\Dto\ExerciseDto;
use App\Exceptions\PermissionException;
use App\Usecase\ExerciseUsecase;
use Illuminate\Database\Eloquent\Collection;
use Mockery as m;
use Tests\TestCase;


class ExerciseUsecaseTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testGetExerciseDtoById()
    {
        $exercise_domain = Exercise::create([
            'question' => 'is this test question.',
            'answer' => 'yes, this is test.'
        ]);
        $exercise_repository = m::mock('\App\Domain\ExerciseRepository');
        $exercise_repository->shouldReceive('findByExerciseId')
            ->once()
            ->with('testid-1', 10)
            ->andReturn($exercise_domain);
        $exercise_usecase = new ExerciseUsecase($exercise_repository);
        $acutal = $exercise_usecase->getExerciseDtoById('testid-1', 10);
        self::assertTrue($acutal instanceof ExerciseDto);
        self::assertSame('is this test question.', $acutal->question);
        self::assertSame('yes, this is test.', $acutal->answer);
    }

    public function testRegisterExercise()
    {
        $exercise_repository = m::mock('\App\Domain\ExerciseRepository');
        $exercise_repository->shouldReceive('save')->once();
        $exercise_usecase = new ExerciseUsecase($exercise_repository);
        $exercise_dto = new ExerciseDto(
            'is this test question.',
            'yes, this is test.',
            Exercise::PUBLIC_EXERCISE,
            10
        );
        $exercise_usecase->registerExercise($exercise_dto);
    }

    public function testEditExercise()
    {
        $exercise_domain = Exercise::create([
            'question' => 'is this test question.',
            'answer' => 'yes, this is test.',
            'author_id' => 10
        ]);
        $modified_exercise_dto = new ExerciseDto(
            'is this modified test question.',
            'yes, this is modified test.',
            Exercise::PUBLIC_EXERCISE,
            10
        );
        $exercise_repository = m::mock('\App\Domain\ExerciseRepository');
        $exercise_repository->shouldReceive('findByExerciseId')
            ->once()
            ->with('exercise-test', 10)
            ->andReturn($exercise_domain);
        $exercise_repository->shouldReceive('save')->once();
        $exercise_usecase = new ExerciseUsecase($exercise_repository);
        $actual = $exercise_usecase->editExercise('exercise-test', 10, $modified_exercise_dto);
        self::assertSame('is this modified test question.', $actual->question);
        self::assertSame('yes, this is modified test.', $actual->answer);
    }

    public function testEditExerciseWithInvalidPermission()
    {
        $exercise_domain = Exercise::create([
            'question' => 'is this test question.',
            'answer' => 'yes, this is test.',
            'author_id' => 10
        ]);
        $modified_exercise_dto = new ExerciseDto(
            'is this modified test question.',
            'yes, this is modified test.',
            Exercise::PUBLIC_EXERCISE,
            15
        );
        $exercise_repository = m::mock('\App\Domain\ExerciseRepository');
        $exercise_repository->shouldReceive('findByExerciseId')
            ->once()
            ->with('exercise-test', 15)
            ->andReturn($exercise_domain);
        $exercise_usecase = new ExerciseUsecase($exercise_repository);
        try {
            $exercise_usecase->editExercise('exercise-test', 15, $modified_exercise_dto);
        } catch (PermissionException $e) {
            self::assertSame('User doesn\'t have permission to edit', $e->getMessage());
        }
    }

    public function testGetAllExercises()
    {
        $user = factory(\App\User::class)->make();
        $exercise_list = factory(\App\Exercise::class, 10)->make();
        $exercise_repository = m::mock('\App\Domain\ExerciseRepository');
        $exercise_repository->shouldReceive('findAll')
            ->once()
            ->with(10, $user, 1)
            ->andReturn($exercise_list);
        $exercise_usecase = new ExerciseUsecase($exercise_repository);
        $actual = $exercise_usecase->getAllExercises(10, $user, 1);
        self::assertTrue($actual instanceof Collection);
    }

    public function testGetExerciseCount()
    {
        $user = factory(\App\User::class)->make();
        $exercise_repository = m::mock('\App\Domain\ExerciseRepository');
        $exercise_repository->shouldReceive('count')
            ->once()
            ->with($user)
            ->andReturn(10);
        $exercise_usecase = new ExerciseUsecase($exercise_repository);
        $actual = $exercise_usecase->getExerciseCount($user);
        self::assertSame(10, $actual);
    }

    public function testGetAllExercisesWithIdList()
    {
        $exercise_list = factory(\App\Exercise::class, 10)->make();
        $exercise_repository = m::mock('\App\Domain\ExerciseRepository');
        $exercise_repository->shouldReceive('findAllByExerciseIdList')
            ->once()
            ->with(["exercise-1", "exercise-2", "exercise-3"])
            ->andReturn($exercise_list);
        $exercise_usecase = new ExerciseUsecase($exercise_repository);
        $actual = $exercise_usecase->getAllExercisesWithIdList(["exercise-1", "exercise-2", "exercise-3"]);
        self::assertTrue($actual instanceof Collection);
    }

    public function testDeleteExercise()
    {
        $exercise_domain = Exercise::create([
            'question' => 'Is this dog?',
            'answer' => 'Yes, it is.',
            'author_id' => 10,
            'exercise_id' => 'exercise-1',
        ]);
        $exercise_repository = m::mock('\App\Domain\ExerciseRepository');
        $exercise_repository->shouldReceive('findByExerciseId')
            ->once()
            ->with("exercise-1", 10)
            ->andReturn($exercise_domain);
        $exercise_repository->shouldReceive('delete')
            ->once()
            ->with("exercise-1")
            ->andReturn();
        $exercise_usecase = new ExerciseUsecase($exercise_repository);
        $exercise_usecase->deleteExercise("exercise-1", 10);
    }

    public function testDeleteExerciseWithoutPermission()
    {
        $exercise_domain = Exercise::create([
            'question' => 'Is this dog?',
            'answer' => 'Yes, it is.',
            'author_id' => 10,
            'exercise_id' => 'exercise-1',
        ]);
        $exercise_repository = m::mock('\App\Domain\ExerciseRepository');
        $exercise_repository->shouldReceive('findByExerciseId')
            ->once()
            ->with("exercise-1", 15)
            ->andReturn($exercise_domain);
        $exercise_usecase = new ExerciseUsecase($exercise_repository);
        try {
            $exercise_usecase->deleteExercise("exercise-1", 15);
        } catch (PermissionException $e) {
            self::assertSame("User doesn't have permission to delete", $e->getMessage());
        }
    }
}
