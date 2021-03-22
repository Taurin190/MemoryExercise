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
        try {
            $exercise = Exercise::create([
                "question" => "Do you like dog?",
                "answer" => "yes, I like."
            ]);
            $actual = $exercise->getExerciseDto();
            self::assertSame("Do you like dog?", $actual->question);
            self::assertSame("yes, I like.", $actual->answer);
            self::assertSame(1, $actual->permission);
            self::assertSame([], $actual->label_list);
            self::assertSame(0, $actual->user_id);
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。" . $e);
        }
    }

    public function testCreateWithFullParameters()
    {
        try {
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
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。" . $e);
        }
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
}
