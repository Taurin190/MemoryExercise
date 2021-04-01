<?php


namespace Tests\Unit\infrastructure;

use App\Exceptions\DataNotFoundException;
use App\Infrastructure\ExerciseRepository;
use Tests\TestCase;

class ExerciseRepositoryTest extends TestCase
{
    public function testFindByExerciseId()
    {
        $exercise_repository = new ExerciseRepository();
        $exercise_domain = $exercise_repository->findByExerciseId('exercise1', 10);
        $actual = $exercise_domain->getExerciseDto();
        self::assertSame('exercise1', $actual->exercise_id);
        self::assertSame(10, $actual->user_id);
        self::assertSame('Is this a dog?', $actual->question);
        self::assertSame('Yes, it is', $actual->answer);
    }

    public function testFindByExerciseIdWithOtherUser()
    {
        $exercise_repository = new ExerciseRepository();
        $exercise_domain = $exercise_repository->findByExerciseId('exercise1', 15);
        $actual = $exercise_domain->getExerciseDto();
        self::assertSame('exercise1', $actual->exercise_id);
        self::assertSame(10, $actual->user_id);
        self::assertSame('Is this a dog?', $actual->question);
        self::assertSame('Yes, it is', $actual->answer);
    }

    public function testFindByExerciseIdWithInvalidId()
    {
        $exercise_repository = new ExerciseRepository();
        try {
            $exercise_repository->findByExerciseId('exercise999', 15);
        } catch (DataNotFoundException $e) {
            self::assertSame('Data not found in exercises by id: exercise999', $e->getMessage());
        }
    }
}
