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
            $actual = $workbook->getDescription();
            self::assertSame("This is an example of workbook.", $actual);
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。");
        }
    }

    public function testCreateWithoutTitle() {
        try {
            Workbook::create("", "This is an example of workbook.");
            self::fail("例外が発生しませんでした。");
        } catch (WorkbookDomainException $e) {
            self::assertSame("タイトルが空です。", $e->getMessage());
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

        $workbook->deleteExercise($this->exerciseMock);
        $exercise_list = $workbook->getExerciseList();
        self::assertIsArray($exercise_list);
        self::assertFalse(in_array($this->exerciseMock, $exercise_list));
    }
}
