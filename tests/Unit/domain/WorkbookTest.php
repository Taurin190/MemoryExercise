<?php

namespace Tests\Unit\domain;

use App\Domain\WorkbookDomainException;
use Tests\TestCase;
use App\Domain\Workbook;
use \Mockery as m;

class WorkbookTest extends TestCase
{
    protected $exerciseMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->exerciseMock = m::mock('\App\Domain\Exercise');
    }
    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }
    public function testCreate() {
        try {
            $workbook = Workbook::create(['title' => "test workbook", 'explanation' => "This is an example of workbook."]);
            self::assertTrue($workbook instanceof Workbook);
            $actual = $workbook->getTitle();
            self::assertSame("test workbook", $actual);
            $actual = $workbook->getExplanation();
            self::assertSame("This is an example of workbook.", $actual);
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。");
        }
    }

    public function testConvertDomain() {
        $model_mock = m::mock('\App\Workbook');
        $model_mock->shouldReceive('getKey')
            ->once()
            ->andReturn(1);
        $model_mock->shouldReceive('getAttribute')
            ->once()
            ->with('title')
            ->andReturn('test workbook');
        $model_mock->shouldReceive('getAttribute')
            ->once()
            ->with('explanation')
            ->andReturn('this is a test workbook');
        $model_mock->shouldReceive('exercises')
            ->once()
            ->andReturn(null);
        $model_mock->shouldReceive('getAttribute')
            ->once()
            ->with('user')
            ->andReturn(null);
        $workbook = Workbook::convertDomain($model_mock);
        self::assertTrue($workbook instanceof Workbook);
        self::assertSame("test workbook", $workbook->getTitle());
        self::assertSame("this is a test workbook", $workbook->getExplanation());
        self::assertSame([], $workbook->getExerciseList());
    }

    public function testCreateWithoutTitle() {
        try {
            Workbook::create(['title' => "", 'explanation' => "This is an example of workbook."]);
            self::fail("例外が発生しませんでした。");
        } catch (WorkbookDomainException $e) {
            self::assertSame("タイトルが空です。", $e->getMessage());
        }
    }

    public function testCreateWithWorkbookId() {
        $actual = Workbook::create([
            'title' => "test title",
            'explanation' => "This is an example of workbook",
            'exercise_list' => null,
            'workbook_id' => "workbook1"
        ]);
        self::assertSame("workbook1", $actual->getWorkbookId());
        self::assertSame("test title", $actual->getTitle());
        self::assertSame("This is an example of workbook", $actual->getExplanation());
        self::assertSame([], $actual->getExerciseList());
    }

    public function testAddExercise() {
        $workbook = null;
        try {
            $workbook = Workbook::create([
                'title' => "test workbook",
                'explanation' => "This is an example of workbook."
            ]);
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。");
        }
        $workbook->addExercise($this->exerciseMock);
        $exercise_list = $workbook->getExerciseList();
        self::assertIsArray($exercise_list);
        self::assertTrue(in_array($this->exerciseMock, $exercise_list));
    }

    public function testModifyOrder() {
        $exercise_mock_list = [];
        for ($i = 0; $i < 5; $i++) {
            $tmp_exercise_mock = m::mock('\App\Domain\Exercise');
            $tmp_exercise_mock->shouldReceive("getQuestion")->andReturn("test" . $i);
            $exercise_mock_list[] = $tmp_exercise_mock;
        }

        $workbook = null;
        try {
            $workbook = Workbook::create([
                'title' => "test workbook",
                'explanation' => "This is an example of workbook."
            ]);
            for ($i = 0; $i < 5; $i++) {
                $workbook->addExercise($exercise_mock_list[$i]);
            }
            $actual_list = $workbook->getExerciseList();
            self::assertSame("test0", $actual_list[0]->getQuestion());
            self::assertSame("test1", $actual_list[1]->getQuestion());
            self::assertSame("test2", $actual_list[2]->getQuestion());
            self::assertSame("test3", $actual_list[3]->getQuestion());
            self::assertSame("test4", $actual_list[4]->getQuestion());

            $workbook->modifyOrder($actual_list[4], 1);
            $actual_list = $workbook->getExerciseList();
            self::assertSame("test4", $actual_list[0]->getQuestion());
            self::assertSame("test0", $actual_list[1]->getQuestion());
            self::assertSame("test1", $actual_list[2]->getQuestion());
            self::assertSame("test2", $actual_list[3]->getQuestion());
            self::assertSame("test3", $actual_list[4]->getQuestion());
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。" . $e);
        }
    }


    public function testModifyOrderWithZeroOrder()
    {
        $exercise_mock_list = [];
        for ($i = 0; $i < 5; $i++) {
            $tmp_exercise_mock = m::mock('\App\Domain\Exercise');
            $tmp_exercise_mock->shouldReceive("getQuestion")->andReturn("test" . $i);
            $exercise_mock_list[] = $tmp_exercise_mock;
        }

        $workbook = null;
        try {
            $workbook = Workbook::create([
                'title' => "test workbook",
                'explanation' => "This is an example of workbook."
            ]);
            for ($i = 0; $i < 5; $i++) {
                $workbook->addExercise($exercise_mock_list[$i]);
            }
            $actual_list = $workbook->getExerciseList();
            self::assertSame("test0", $actual_list[0]->getQuestion());
            self::assertSame("test1", $actual_list[1]->getQuestion());
            self::assertSame("test2", $actual_list[2]->getQuestion());
            self::assertSame("test3", $actual_list[3]->getQuestion());
            self::assertSame("test4", $actual_list[4]->getQuestion());
            $workbook->modifyOrder($actual_list[4], 0);
        } catch (WorkbookDomainException $e) {
            self::assertSame("指定された順番が不正です。", $e->getMessage());
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。" . $e);
        }
    }


    public function testModifyOrderWithInvalidOrder()
    {
        $exercise_mock_list = [];
        for ($i = 0; $i < 5; $i++) {
            $tmp_exercise_mock = m::mock('\App\Domain\Exercise');
            $tmp_exercise_mock->shouldReceive("getQuestion")->andReturn("test" . $i);
            $exercise_mock_list[] = $tmp_exercise_mock;
        }

        $workbook = null;
        try {
            $workbook = Workbook::create([
                'title' => "test workbook",
                'explanation' => "This is an example of workbook."
            ]);
            for ($i = 0; $i < 5; $i++) {
                $workbook->addExercise($exercise_mock_list[$i]);
            }
            $actual_list = $workbook->getExerciseList();
            self::assertSame("test0", $actual_list[0]->getQuestion());
            self::assertSame("test1", $actual_list[1]->getQuestion());
            self::assertSame("test2", $actual_list[2]->getQuestion());
            self::assertSame("test3", $actual_list[3]->getQuestion());
            self::assertSame("test4", $actual_list[4]->getQuestion());
            $workbook->modifyOrder($actual_list[4], 5);
        } catch (WorkbookDomainException $e) {
            self::assertSame("指定された順番が不正です。", $e->getMessage());
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。" . $e);
        }
    }

    public function testToArray() {
        $exercise_mock_list = [];
        for ($i = 0; $i < 5; $i++) {
            $tmp_exercise_mock = m::mock('\App\Domain\Exercise');
            $tmp_exercise_mock->shouldReceive("toArray")->andReturn([
                "exercise_id" => "id" . $i,
                "question" => "test" . $i,
                "answer" => "answer" . $i
            ]);
            $exercise_mock_list[] = $tmp_exercise_mock;
        }

        $workbook = null;
        try {
            $workbook = Workbook::create([
                'title' =>"test workbook",
                'explanation' => "This is an example of workbook."
            ]);
            for ($i = 0; $i < 5; $i++) {
                $workbook->addExercise($exercise_mock_list[$i]);
            }
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。" . $e);
        }
        $actual = $workbook->toArray();
        self::assertSame([
            "workbook_id" => null,
            "title" => "test workbook",
            "explanation" => "This is an example of workbook.",
            "exercise_list" => [
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
                ],
                [
                    "exercise_id" => "id3",
                    "question" => "test3",
                    "answer" => "answer3"
                ],
                [
                    "exercise_id" => "id4",
                    "question" => "test4",
                    "answer" => "answer4"
                ],
            ]
        ],$actual);
    }
}
