<?php


namespace Tests\Unit\dto;


use App\Dto\ExerciseDto;
use App\Dto\WorkbookDto;
use Tests\TestCase;

class WorkbookDtoTest extends TestCase
{
    public function testToArray()
    {
        $workbook_dto = new WorkbookDto(
            'test-title',
            'this is test workbook',
            [],
            10,
            'test-workbook-1'
        );
        $actual = $workbook_dto->toArray();
        self::assertSame('test-title', $actual['title']);
        self::assertSame('this is test workbook', $actual['explanation']);
        self::assertSame([], $actual['exercise_list']);
        self::assertSame('test-workbook-1', $actual['workbook_id']);
    }

    public function testToArrayWithExerciseList()
    {
        $exercise_dto_list = [];
        for ($i = 0; $i < 10; $i++) {
            $exercise_dto_list[] = new ExerciseDto(
                'Is this dog?' . $i,
                'Yes, it is.',
                1,
                10,
                'exercise-test-' . $i,
                []
            );
        }
        $workbook_dto = new WorkbookDto(
            'test-title',
            'this is test workbook',
            $exercise_dto_list,
            10,
            'test-workbook-1'
        );
        $actual = $workbook_dto->toArray();
        self::assertSame('test-title', $actual['title']);
        self::assertSame('this is test workbook', $actual['explanation']);
        self::assertSame(10, count($actual['exercise_list']));
        self::assertSame('test-workbook-1', $actual['workbook_id']);
    }
}
