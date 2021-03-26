<?php

namespace Tests\Unit\usecase;

use App\Domain\Exercise;
use App\Dto\ExerciseDto;
use App\Exceptions\PermissionException;
use App\Usecase\ExerciseUsecase;
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
}
