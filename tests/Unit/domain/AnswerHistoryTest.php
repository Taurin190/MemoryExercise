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
    public function setUp(): void
    {
        parent::setUp();
    }
    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }
    public function testMap()
    {
        $exercise_mock_list = [];
        $exercise_mock1 = m::mock('\App\Domain\Exercise');
        $exercise_mock2 = m::mock('\App\Domain\Exercise');
        $exercise_mock3 = m::mock('\App\Domain\Exercise');
        $exercise_mock1->shouldReceive('getExerciseId')
            ->once()->andReturn('exercise1');
        $exercise_mock2->shouldReceive('getExerciseId')
            ->once()->andReturn('exercise2');
        $exercise_mock3->shouldReceive('getExerciseId')
            ->once()->andReturn('exercise3');
        $exercise_mock_list[] = $exercise_mock1;
        $exercise_mock_list[] = $exercise_mock2;
        $exercise_mock_list[] = $exercise_mock3;

        $exercise_history_mock = m::mock('alias:\App\Domain\ExerciseHistory');
        $exercise_history_mock->shouldReceive('create')
            ->with(1, $exercise_mock1, 'ng')->once()->andReturn($exercise_history_mock);
        $exercise_history_mock->shouldReceive('create')
            ->with(1, $exercise_mock2, 'ng')->once()->andReturn($exercise_history_mock);
        $exercise_history_mock->shouldReceive('create')
            ->with(1, $exercise_mock3, 'ng')->once()->andReturn($exercise_history_mock);


        $answer_mock = m::mock('App\Domain\Answer');
        $workbook_history_mock = m::mock('alias:App\Domain\WorkbookHistory');
        $workbook_mock = m::mock('App\Domain\Workbook');

        $answer_mock->shouldReceive('getExerciseMap')
            ->once()->andReturn(['exercise1' => 'ng', 'exercise2' => 'ng', 'exercise3' => 'ng']);
        $workbook_mock->shouldReceive('getExerciseList')
            ->once()->andReturn($exercise_mock_list);
        $workbook_history_mock->shouldReceive('map')
            ->with($answer_mock, $workbook_mock, 1)->once()->andReturn($workbook_history_mock);

        $actual = AnswerHistory::map($answer_mock, $workbook_mock, 1);

        self::assertTrue($actual instanceof AnswerHistory);
        self::assertTrue($actual->getWorkbookHistory() instanceof WorkbookHistory);
        self::assertIsArray($actual->getExerciseHistoryList());
    }
}
