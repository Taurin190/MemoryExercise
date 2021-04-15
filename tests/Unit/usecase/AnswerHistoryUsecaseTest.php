<?php


namespace Tests\Unit\usecase;


use App\Domain\ExerciseDailyTable;
use App\Dto\AnswerDto;
use App\Dto\WorkbookDto;
use App\Usecase\AnswerHistoryUsecase;
use DateTime;
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
        $answer_history_repository->shouldReceive('save')->once();
        $answer_history_usecase = new AnswerHistoryUsecase($answer_history_repository);
        $answer_history_usecase->registerAnswerHistory($workbook_dto, $answer_dto, $user);
    }

    public function testGetStudyHistoryOfUser()
    {
        $graph_date_since = new DateTime('first day of this month');
        $graph_date_until = new DateTime('last day of this month');
        $exercise_daily_table = new ExerciseDailyTable($graph_date_since, $graph_date_until);
        $answer_history_repository = m::mock('\App\Domain\AnswerHistoryRepository');
        $answer_history_repository->shouldReceive('getExerciseHistoryDailyCountTableWithinTerm')
            ->andReturn($exercise_daily_table);
        $answer_history_repository->shouldReceive('getExerciseHistoryCountByUserIdWithinTerm')
        ->andReturn(20);
        $answer_history_repository->shouldReceive('getExerciseHistoryTotalCount')
            ->with(10)
            ->andReturn(2);
        $answer_history_repository->shouldReceive('getExerciseHistoryTotalDays')
            ->with(10)
            ->andReturn(15);

        $answer_history_usecase = new AnswerHistoryUsecase($answer_history_repository);
        $actual = $answer_history_usecase->getStudyHistoryOfUser(10, $graph_date_since, $graph_date_until);
        self::assertSame(20, $actual->monthlyCount);
        self::assertSame(2, $actual->totalCount);
        self::assertSame(15, $actual->totalDays);
    }
}
