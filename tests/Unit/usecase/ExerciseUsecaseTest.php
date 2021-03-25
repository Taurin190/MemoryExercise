<?php

namespace Tests\Unit\usecase;

use App\Domain\Exercise;
use App\Dto\ExerciseDto;
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
            'answer' => 'yes, this is test.',

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
        $exercise_repository->shouldReceive('save')
            ->once();
        $exercise_usecase = new ExerciseUsecase($exercise_repository);
        $exercise_dto = new ExerciseDto(
            'is this test question.',
            'yes, this is test.',
            Exercise::PUBLIC_EXERCISE,
            10
        );
        $exercise_usecase->registerExercise($exercise_dto);
    }
}
