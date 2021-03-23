<?php

namespace Tests\Unit\domain;

use App\Domain\DomainException;
use App\Domain\Exercises;
use App\Domain\Workbook;
use App\Dto\ExerciseDto;
use Mockery as m;
use Tests\TestCase;

class WorkbookTest extends TestCase
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

    public function testCreate()
    {
        $workbook = Workbook::create(['title' => "test workbook", 'explanation' => "This is an example of workbook."]);
        self::assertTrue($workbook instanceof Workbook);
        $actual = $workbook->getWorkbookDto();
        self::assertSame("test workbook", $actual->title);
        self::assertSame("This is an example of workbook.", $actual->explanation);
    }

    public function testCreateWithFullParameters()
    {
        $exercise_dto_list = [];
        for ($i = 0; $i < 10; $i++) {
            $exercise_dto_list[] = new ExerciseDto('question' . $i, 'answer' . $i, 1, 10);
        }
        $user = factory(\App\User::class)->make();
        $workbook = Workbook::create([
            'title' => "test workbook",
            'explanation' => "This is an example of workbook.",
            'exercise_list' => Exercises::convertByDtoList($exercise_dto_list),
            'workbook_id' => 'test-workbook',
            'user' => $user
        ]);
        self::assertTrue($workbook instanceof Workbook);
        $actual = $workbook->getWorkbookDto();
        self::assertSame("test workbook", $actual->title);
        self::assertSame("This is an example of workbook.", $actual->explanation);
        self::assertTrue(is_array($actual->exercise_list));
        self::assertSame("test-workbook", $actual->workbook_id);
    }

    public function testCreateWithoutTitle()
    {
        try {
            Workbook::create(['explanation' => "This is an example of workbook."]);
            self::fail("タイトルが未入力時に例外が発生しませんでした。");
        } catch (DomainException $e) {
            self::assertSame("タイトルが空です。", $e->getMessage());
        }
    }

    public function testCreateInvalidTypeOfExerciseList()
    {
        try {
            Workbook::create([
                'title' => "test workbook",
                'explanation' => "This is an example of workbook.",
                'exercise_list' => []
            ]);
            self::fail("不正なExercises型で時に例外が発生しませんでした。");
        } catch (DomainException $e) {
            self::assertSame("Invalid Type Error.", $e->getMessage());
        }
    }

    public function testConvertByOrmList()
    {
        $workbook_orm = factory(\App\Workbook::class)->make([
            'title' => "test workbook",
            'explanation' => "This is an example of workbook."
        ]);
        $workbook = Workbook::convertDomain($workbook_orm);
        self::assertTrue($workbook instanceof Workbook);
        $actual = $workbook->getWorkbookDto();
        self::assertSame("test workbook", $actual->title);
        self::assertSame("This is an example of workbook.", $actual->explanation);
    }

    public function testHasEditPermission()
    {
        $user = factory(\App\User::class)->make(['id' => 10]);
        $workbook = Workbook::create([
            'title' => "test workbook",
            'explanation' => "This is an example of workbook.",
            'workbook_id' => 'test-workbook',
            'user' => $user
        ]);
        self::assertTrue($workbook->hasEditPermission(10));
        self::assertFalse($workbook->hasEditPermission(15));
    }
}
