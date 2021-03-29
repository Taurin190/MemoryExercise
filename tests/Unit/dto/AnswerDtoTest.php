<?php


namespace Tests\Unit\dto;


use App\Dto\AnswerDto;
use Tests\TestCase;

class AnswerDtoTest extends TestCase
{
    public function testGetExerciseCount()
    {
        $exercise_list_request = [
            'test-exercise-1',
            'test-exercise-2',
            'test-exercise-3'
        ];
        $answer_list_request = [
            'test-exercise-1' => 'ok',
            'test-exercise-2' => 'ng',
            'test-exercise-3' => 'studying'
        ];
        $answer_dto = new AnswerDto($exercise_list_request, $answer_list_request);
        self::assertSame(3, $answer_dto->getExerciseCount());
    }

    public function testToGraphData()
    {
        $exercise_list_request = [
            'test-exercise-1',
            'test-exercise-2',
            'test-exercise-3'
        ];
        $answer_list_request = [
            'test-exercise-1' => 'ok',
            'test-exercise-2' => 'ng',
            'test-exercise-3' => 'studying'
        ];
        $answer_dto = new AnswerDto($exercise_list_request, $answer_list_request);
        $actual = $answer_dto->toGraphData();
        self::assertSame([
            'labels' => ['OK', 'Studying', 'NG'],
            'datasets' => [
                'label' => '回答数',
                'backgroundColor' => '#f87979',
                'data' => [1, 1, 1],
            ],
        ], $actual);
    }
}
