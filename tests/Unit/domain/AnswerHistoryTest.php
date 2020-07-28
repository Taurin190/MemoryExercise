<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/07/27
 * Time: 21:48
 */

namespace Tests\Unit\domain;
use Tests\TestCase;
use App\Domain\AnswerHistory;
use App\Domain\WorkbookHistory;
use \Mockery as m;

class AnswerHistoryTest extends TestCase
{
    public function testMap()
    {
        $answer_mock = m::mock('alias:App\Domain\Answer');
        $workbook_history_mock = m::mock('alias:App\Domain\WorkbookHistory');
        $workbook_mock = m::mock('App\Domain\Workbook');
        $workbook_history_mock->shouldReceive('map')
            ->with($workbook_mock)->once()->andReturn($workbook_history_mock);


        $exercise_mock_list = [];
        $exercise_mock1 = m::mock('App\Domain\Exercise');
        $exercise_mock2 = m::mock('App\Domain\Exercise');
        $exercise_mock3 = m::mock('App\Domain\Exercise');
        $exercise_mock_list[] = $exercise_mock1;
        $exercise_mock_list[] = $exercise_mock2;
        $exercise_mock_list[] = $exercise_mock3;

        $exercise_history_mock = m::mock('alias:App\Domain\ExerciseHistory');
        $exercise_history_mock->shouldReceive('map')
            ->with($exercise_mock1)->once()->andReturn($exercise_history_mock);
        $exercise_history_mock->shouldReceive('map')
            ->with($exercise_mock2)->once()->andReturn($exercise_history_mock);
        $exercise_history_mock->shouldReceive('map')
            ->with($exercise_mock3)->once()->andReturn($exercise_history_mock);


        $answer_mock->shouldReceive('getWorkbook')
            ->once()->andReturn($workbook_mock);
        $answer_mock->shouldReceive('getExerciseList')
            ->once()->andReturn($exercise_mock_list);

        $actual = AnswerHistory::map($answer_mock);

        self::assertTrue($actual instanceof AnswerHistory);
        self::assertTrue($actual->getWorkbookHistory() instanceof WorkbookHistory);
        self::assertIsArray($actual->getExerciseHistoryList());
    }
}
