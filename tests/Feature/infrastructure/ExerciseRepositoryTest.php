<?php


namespace Tests\Unit\infrastructure;

use App\Domain\Exercise;
use App\Domain\Exercises;
use App\Domain\SearchExerciseList;
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

    public function testFindByExerciseIdWithoutUser()
    {
        $exercise_repository = new ExerciseRepository();
        $exercise_domain = $exercise_repository->findByExerciseId('exercise1');
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

    public function testFindAllByExerciseIdList()
    {
        $exercise_repository = new ExerciseRepository();
        $actual = $exercise_repository->findAllByExerciseIdList(['exercise1', 'exercise2', 'exercise3'], 10);
        self::assertTrue($actual instanceof Exercises);
        self::assertSame(3, $actual->count());
    }

    public function testFindAllByExerciseIdListWithoutUserId()
    {
        $exercise_repository = new ExerciseRepository();
        $actual = $exercise_repository->findAllByExerciseIdList(['exercise1', 'exercise2', 'exercise3']);
        self::assertTrue($actual instanceof Exercises);
        self::assertSame(2, $actual->count());
    }

    public function testFindAllByExerciseIdListWithOtherUserId()
    {
        $exercise_repository = new ExerciseRepository();
        $actual = $exercise_repository->findAllByExerciseIdList(['exercise2', 'exercise3', 'exercise4'], 15);
        self::assertTrue($actual instanceof Exercises);
        self::assertSame(1, $actual->count());
    }

    public function testFindAllByExerciseIdListAndGetNull()
    {
        $exercise_repository = new ExerciseRepository();
        $actual = $exercise_repository->findAllByExerciseIdList(['exercise3', 'exercise4']);
        self::assertTrue($actual instanceof Exercises);
        self::assertSame(0, $actual->count());
    }

    public function testSave()
    {
        $workbook_domain = Exercise::create([
            'question' => 'testSave. Is this test question?',
            'answer' => 'yes, this is test one',
            'permission' => 1,
            'author_id' => 15
        ]);
        $exercise_repository = new ExerciseRepository();
        $exercise_repository->save($workbook_domain);
        $actual = $exercise_repository->searchCount('testSave');
        self::assertSame(1, $actual);
        $exercise_list = $exercise_repository->search('testSave');
        self::assertSame(1, $exercise_list->count());
        //TODO 取り出し方を改善する
        foreach ($exercise_list->getExerciseListDto()->exercise_dto_list as $dto) {
            $exercise_repository->delete($dto->exercise_id);
        }
    }

    public function testCount()
    {
        $user = factory(\App\User::class)->make(['id' => 10]);
        $exercise_repository = new ExerciseRepository();
        $actual = $exercise_repository->count($user);
        self::assertSame(5, $actual);
    }

    public function testCountWithoutUser()
    {
        $exercise_repository = new ExerciseRepository();
        $actual = $exercise_repository->count();
        self::assertSame(3, $actual);
    }

    public function testCountWithOtherUser()
    {
        $user = factory(\App\User::class)->make(['id' => 15]);
        $exercise_repository = new ExerciseRepository();
        $actual = $exercise_repository->count($user);
        self::assertSame(3, $actual);
    }

    public function testSearchWithFewText()
    {
        $exercise_repository = new ExerciseRepository();
        $search_result = $exercise_repository->search('a');
        self::assertTrue($search_result instanceof SearchExerciseList);
        self::assertSame(3, $search_result->count());
    }
}
