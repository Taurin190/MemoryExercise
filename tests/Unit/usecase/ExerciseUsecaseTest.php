<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/05/21
 * Time: 6:33
 */

namespace Tests\Unit\usecase;
use Tests\TestCase;
use App\Domain\Exercise;
use App\Http\Requests\ExerciseRequest;
use App\Infrastructure\ExerciseRepository;
use App\Usecase\ExerciseUsecase;

use \Mockery as m;

class ExerciseUsecaseTest extends TestCase
{
    protected $exerciseDomain;

    protected $exerciseRequest;

    protected $exerciseRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->exerciseDomain = m::mock('alias:App\Domain\Exercise');
        $this->exerciseRequest = m::mock('App\Http\Requests\ExerciseRequest');
        $this->exerciseRepository = m::mock('App\Infrastructure\ExerciseRepository');
    }
    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }
    public function testCreateExerciseFromRequest()
    {
        $this->exerciseRequest->shouldReceive('get')->with('question')->once()->andReturn('Is this dog?');
        $this->exerciseRequest->shouldReceive('get')->with('answer')->once()->andReturn('Yes, it is');
        $this->exerciseDomain->shouldReceive('create')->with('Is this dog?','Yes, it is')->once()->andReturn($this->exerciseDomain);
        $this->exerciseRepository->shouldReceive('save')->with($this->exerciseDomain)->once()->andReturn();
        $exercise_usecase = new ExerciseUsecase($this->exerciseRepository);
        $exercise_usecase->createExerciseFromRequest($this->exerciseRequest);
    }

    public function testSearchExercise() {
        $exercise_usecase = new ExerciseUsecase($this->exerciseRepository);
        $this->exerciseRepository->shouldReceive('search')->with("", 1)->once()->andReturn([
            [
                "exercise_id" => "id0",
                "question" => "test0",
                "answer" => "answer0"
            ],
            [
                "exercise_id" => "id1",
                "question" => "test1",
                "answer" => "answer1"
            ],
            [
                "exercise_id" => "id2",
                "question" => "test2",
                "answer" => "answer2"
            ]
        ]);
        $actual = $exercise_usecase->searchExercise("", 1);
        self::assertSame([
            [
                "exercise_id" => "id0",
                "question" => "test0",
                "answer" => "answer0"
            ],
            [
                "exercise_id" => "id1",
                "question" => "test1",
                "answer" => "answer1"
            ],
            [
                "exercise_id" => "id2",
                "question" => "test2",
                "answer" => "answer2"
            ]
        ], $actual);
    }
}
