<?php


namespace Tests\Unit\usecase;


use App\Dto\AnswerDto;
use App\Dto\WorkbookDto;
use App\Usecase\AnswerHistoryUsecase;
use Mockery as m;
use Tests\TestCase;

class AnswerHistoryUsecaseTest extends TestCase
{
    public function testRegisterAnswerHistory()
    {
        $exercise_id_list = [
            'exercise-test-1',
            'exercise-test-2',
            'exercise-test-3'
        ];
        $answer_list = [
            'exercise-test-1' => 'ok',
            'exercise-test-2' => 'ng',
            'exercise-test-3' => 'studying'
        ];
        $user = factory(\App\User::class)->make(['id' => 10]);
        $answer_dto = new AnswerDto($exercise_id_list, $answer_list);
        $workbook_dto = new WorkbookDto(
            "test workbook",
            "This is an example of workbook.",
            [],
            10,
            'test-workbook'
        );
        $answer_history_repository = m::mock('\App\Domain\AnswerHistoryRepository');
        $workbook_repository = m::mock('\App\Domain\WorkbookRepository');
        $answer_history_repository->shouldReceive('save')->once();
        $answer_history_usecase = new AnswerHistoryUsecase($answer_history_repository, $workbook_repository);
        $answer_history_usecase->registerAnswerHistory($workbook_dto, $answer_dto, $user);
    }
}
