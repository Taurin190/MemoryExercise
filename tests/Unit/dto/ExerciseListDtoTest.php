<?php


namespace Tests\Unit\dto;


use App\Dto\ExerciseDto;
use App\Dto\ExerciseListDto;
use Tests\TestCase;

class ExerciseListDtoTest extends TestCase
{
    public function testToArray()
    {
        $exercise_dto_list = [];
        for ($i = 0; $i < 3; $i++) {
            $exercise_dto_list[] = new ExerciseDto(
                'Is this dog?' . $i,
                'Yes, it is.',
                1,
                10,
                'exercise-test-' . $i,
                []
            );
        }
        $exercise_list_dto = new ExerciseListDto(20, $exercise_dto_list, 1);
        $actual = $exercise_list_dto->toArray();
        self::assertSame([
            [
                'exercise_id' => 'exercise-test-0',
                'question' => 'Is this dog?0',
                'answer' => 'Yes, it is.',
                'permission' => 1,
                'author_id' => 10,
                'user_id' => 10,
                'label_list' => [],
            ],
            [
                'exercise_id' => 'exercise-test-1',
                'question' => 'Is this dog?1',
                'answer' => 'Yes, it is.',
                'permission' => 1,
                'author_id' => 10,
                'user_id' => 10,
                'label_list' => [],
            ],
            [
                'exercise_id' => 'exercise-test-2',
                'question' => 'Is this dog?2',
                'answer' => 'Yes, it is.',
                'permission' => 1,
                'author_id' => 10,
                'user_id' => 10,
                'label_list' => [],
            ],
        ], $actual);
    }
}
