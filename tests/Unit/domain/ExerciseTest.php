<?php

namespace Tests\Unit\domain;

use App\Domain\DomainException;
use App\Domain\Exercise;
use Tests\TestCase;

class ExerciseTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testCreateWithLeastParameters()
    {
        $exercise = Exercise::create([
            "question" => "Do you like dog?",
            "answer" => "yes, I like."
        ]);
        $actual = $exercise->getExerciseDto();
        self::assertSame("Do you like dog?", $actual->question);
        self::assertSame("yes, I like.", $actual->answer);
        self::assertSame(Exercise::PUBLIC_EXERCISE, $actual->permission);
        self::assertSame([], $actual->label_list);
        self::assertSame(0, $actual->user_id);
    }

    public function testCreateWithFullParameters()
    {

        $exercise = Exercise::create([
            "question" => "Do you like dog?",
            "answer" => "yes, I like.",
            "permission" => Exercise::PRIVATE_EXERCISE,
            "label_list" => ["animal", "dog"],
            "author_id" => 20,
        ]);
        $actual = $exercise->getExerciseDto();
        self::assertSame("Do you like dog?", $actual->question);
        self::assertSame("yes, I like.", $actual->answer);
        self::assertSame(Exercise::PRIVATE_EXERCISE, $actual->permission);
        self::assertSame(["animal", "dog"], $actual->label_list);
        self::assertSame(20, $actual->user_id);
    }

    public function testCreateExceptionWithNullQuestion()
    {
        try {
            Exercise::create(["answer" => "yes, I like."]);
        } catch (DomainException $e) {
            self::assertSame('質問が空です。', $e->getMessage());
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。" . $e);
        }
    }

    public function testCreateExceptionWithEmptyQuestion()
    {
        try {
            Exercise::create(["question" => "", "answer" => "yes, I like."]);
        } catch (DomainException $e) {
            self::assertSame('質問が空です。', $e->getMessage());
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。" . $e);
        }
    }

    public function testCreateExceptionWithNullAnswer()
    {
        try {
            Exercise::create(["question" => "Do you like dog?"]);
        } catch (DomainException $e) {
            self::assertSame('解答が空です。', $e->getMessage());
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。" . $e);
        }
    }

    public function testCreateExceptionWithEmptyAnswer()
    {
        try {
            Exercise::create(["question" => "Do you like dog?", "answer" => ""]);
        } catch (DomainException $e) {
            self::assertSame('解答が空です。', $e->getMessage());
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。" . $e);
        }
    }

    public function testGetExerciseId()
    {
        $exercise = Exercise::create([
            "exercise_id" => "test-exercise1",
            "question" => "Do you like dog?",
            "answer" => "Yes, I like."
        ]);
        self::assertSame("test-exercise1", $exercise->getExerciseId());
    }

    public function testGetExerciseIdWithoutId()
    {
        $exercise = Exercise::create([
            "question" => "Do you like dog?",
            "answer" => "Yes, I like."
        ]);
        self::assertNull($exercise->getExerciseId());
    }

    public function testHasPermission()
    {
        $exercise = Exercise::create([
            "question" => "Do you like dog?",
            "answer" => "Yes, I like.",
            "author_id" => 10
        ]);
        self::assertTrue($exercise->hasEditPermission(10));
    }

    public function testHasPermissionWithDifferentUser()
    {
        $exercise = Exercise::create([
            "question" => "Do you like dog?",
            "answer" => "Yes, I like.",
            "author_id" => 10
        ]);
        self::assertFalse($exercise->hasEditPermission(15));
    }

    public function testEdit()
    {
        $exercise = Exercise::create([
            "question" => "Do you like dog?",
            "answer" => "yes, I like."
        ]);
        $exercise->edit([
            "question" => "Do you like cat?",
            "answer" => "No, I don't.",
            "permission" => Exercise::PRIVATE_EXERCISE,
            "label_list" => ["animal", "dog"],
            "author_id" => 10
        ]);

        $actual = $exercise->getExerciseDto();
        self::assertSame("Do you like cat?", $actual->question);
        self::assertSame("No, I don't.", $actual->answer);
        self::assertSame(Exercise::PRIVATE_EXERCISE, $actual->permission);
        self::assertSame(["animal", "dog"], $actual->label_list);
        self::assertSame(0, $actual->user_id);
    }

    public function testEditWithEmptyLabelList()
    {
        $exercise = Exercise::create([
            "question" => "Do you like dog?",
            "answer" => "yes, I like.",
            "label_list" => ["animal", "dog"]
        ]);
        $exercise->edit([
            "label_list" => []
        ]);
        $actual = $exercise->getExerciseDto();
        self::assertSame("Do you like dog?", $actual->question);
        self::assertSame("yes, I like.", $actual->answer);
        self::assertSame(Exercise::PUBLIC_EXERCISE, $actual->permission);
        self::assertSame([], $actual->label_list);
    }

    public function testEditWithoutLabelList()
    {
        $exercise = Exercise::create([
            "question" => "Do you like dog?",
            "answer" => "yes, I like.",
            "label_list" => ["animal", "dog"]
        ]);
        $exercise->edit([
            "question" => "Do you like cat?",
            "answer" => "No, I don't."
        ]);
        $actual = $exercise->getExerciseDto();
        self::assertSame("Do you like cat?", $actual->question);
        self::assertSame("No, I don't.", $actual->answer);
        self::assertSame(Exercise::PUBLIC_EXERCISE, $actual->permission);
        self::assertSame(["animal", "dog"], $actual->label_list);
    }

    public function testIsRegisteredDomain()
    {
        $exercise = Exercise::create([
            "exercise_id" => "exercise1",
            "question" => "Do you like dog?",
            "answer" => "yes, I like."
        ]);
        self::assertTrue($exercise->isRegisteredDomain());
    }

    public function testIsRegisteredDomainWithNewDomain()
    {
        $exercise = Exercise::create([
            "question" => "Do you like dog?",
            "answer" => "yes, I like."
        ]);
        self::assertFalse($exercise->isRegisteredDomain());
    }
}
