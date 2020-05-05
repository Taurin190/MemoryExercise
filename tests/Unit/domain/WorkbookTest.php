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
    public function testCreate() {
        try {
            $workbook = Workbook::create("test workbook", "This is an example of workbook.");
            self::assertTrue($workbook instanceof Workbook);
            $actual = $workbook->getTitle();
            self::assertSame("test workbook", $actual);
            $actual = $workbook->getExplanation();
            self::assertSame("This is an example of workbook.", $actual);
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。");
        }
    }

    public function testMap() {
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
        $workbook = Workbook::map($model_mock);
        self::assertTrue($workbook instanceof Workbook);
        self::assertSame("test workbook", $workbook->getTitle());
        self::assertSame("this is a test workbook", $workbook->getExplanation());
    }

    public function testCreateWithoutTitle() {
        try {
            Workbook::create("", "This is an example of workbook.");
            self::fail("例外が発生しませんでした。");
        } catch (WorkbookDomainException $e) {
            self::assertSame("タイトルが空です。", $e->getMessage());
        }
    }

    public function testModifyTitle() {
        try {
            $workbook = Workbook::create("test workbook", "This is an example of workbook.");
            self::assertTrue($workbook instanceof Workbook);
            $actual = $workbook->getTitle();
            self::assertSame("test workbook", $actual);

            $workbook->modifyTitle("modified test workbook");
            $actual = $workbook->getTitle();
            self::assertSame("modified test workbook", $actual);
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。" . $e);
        }
    }

    public function testModifyTitleToEmpty() {
        try {
            $workbook = Workbook::create("test workbook", "This is an example of workbook.");
            self::assertTrue($workbook instanceof Workbook);
            $actual = $workbook->getTitle();
            self::assertSame("test workbook", $actual);

            $workbook->modifyTitle("");
            self::fail("例外が発生しませんでした。");
        } catch (WorkbookDomainException $e) {
            self::assertSame("タイトルが空です。", $e->getMessage());
        } catch (\Exception $e) {
            self::fail($e);
        }
    }

    public function testModifyExplanation() {
        try {
            $workbook = Workbook::create("test workbook", "This is an example of workbook.");
            self::assertTrue($workbook instanceof Workbook);
            $actual = $workbook->getExplanation();
            self::assertSame("This is an example of workbook.", $actual);

            $workbook->modifyExplanation("modified example of workbook.");
            $actual = $workbook->getExplanation();
            self::assertSame("modified example of workbook.", $actual);
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。" . $e);
        }
    }

    public function testAddExercise() {
        $workbook = null;
        try {
            $workbook = Workbook::create("test workbook", "This is an example of workbook.");
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。");
        }
        $workbook->addExercise($this->exerciseMock);
        $exercise_list = $workbook->getExerciseList();
        self::assertIsArray($exercise_list);
        self::assertTrue(in_array($this->exerciseMock, $exercise_list));
    }

    public function testDeleteExercise() {
        $workbook = null;
        try {
            $workbook = Workbook::create("test workbook", "This is an example of workbook.");
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。");
        }
        $workbook->addExercise($this->exerciseMock);
        $exercise_list = $workbook->getExerciseList();
        self::assertIsArray($exercise_list);
        self::assertTrue(in_array($this->exerciseMock, $exercise_list));

        try {
            $workbook->deleteExercise($this->exerciseMock);
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。");
        }
        $exercise_list = $workbook->getExerciseList();
        self::assertIsArray($exercise_list);
        self::assertFalse(in_array($this->exerciseMock, $exercise_list));
    }

    public function testDeleteExerciseNotIncludedValue() {
        $workbook = null;
        try {
            $workbook = Workbook::create("test workbook", "This is an example of workbook.");
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。");
        }
        try {
            $workbook->deleteExercise($this->exerciseMock);
            self::fail("予期した例外が発生しませんでした。");
        } catch (WorkbookDomainException $e) {
            self::assertSame("削除対象の要素が配列に存在しません。", $e->getMessage());
        }
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
            $workbook = Workbook::create("test workbook", "This is an example of workbook.");
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
            $workbook = Workbook::create("test workbook", "This is an example of workbook.");
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
            $workbook = Workbook::create("test workbook", "This is an example of workbook.");
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
}
