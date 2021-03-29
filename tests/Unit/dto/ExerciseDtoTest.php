<?php


namespace Tests\Unit\dto;


use App\Dto\ExerciseDto;
use Tests\TestCase;

class ExerciseDtoTest extends TestCase
{
    public function testToArray()
    {
        $exercise_dto = new ExerciseDto(
            'Is this dog?',
            'Yes, it is.',
            1,
            10,
            'exercise-test-1',
            []
        );
        $actual = $exercise_dto->toArray();
        self::assertSame('Is this dog?', $actual['question']);
        self::assertSame('Yes, it is.', $actual['answer']);
        self::assertSame(1, $actual['permission']);
        self::assertSame(10, $actual['user_id']);
        self::assertSame('exercise-test-1', $actual['exercise_id']);
    }
}
