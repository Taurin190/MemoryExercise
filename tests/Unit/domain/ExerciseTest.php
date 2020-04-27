<?php

namespace Tests\Unit\domain;
use Tests\TestCase;
use App\Domain\Exercise;
use App\Domain\DomainException;

class ExerciseTest extends TestCase
{
    public function testCreate() {
        $exercise = null;
        try {
            $exercise = Exercise::create("Do you like dog?", "yes, I like.");
            $actual = $exercise->getQuestion();
            self::assertSame("Do you like dog?", $actual);
            $actual = $exercise->getAnswer();
            self::assertSame("yes, I like.", $actual);
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。" . $e);
        }
    }

    public function testCreateWithoutQuestion() {
        try {
            Exercise::create("", "yes, I like.");
            self::fail("例外が発生しませんでした。");
        } catch (DomainException $e) {
            self::assertSame("質問が空です。", $e->getMessage());
        }
    }

    public function testCreateWithoutAnswer() {
        try {
            Exercise::create("Do you like dog?", "");
            self::fail("例外が発生しませんでした。");
        } catch (DomainException $e) {
            self::assertSame("解答が空です。", $e->getMessage());
        }
    }

    public function testSetQuestion() {
        try {
            $exercise = Exercise::create("Do you like dog?", "yes, I like.");
            $actual = $exercise->getQuestion();
            self::assertSame("Do you like dog?", $actual);
            $exercise->setQuestion("Do you like cat?");
            $actual = $exercise->getQuestion();
            self::assertSame("Do you like cat?", $actual);
        } catch (DomainException $e) {
            self::fail("予期しない例外が発生しました。" . $e);
        }
    }

    public function testSetQuestionWithEmpty() {
        try {
            $exercise = Exercise::create("Do you like dog?", "yes, I like.");
            $actual = $exercise->getQuestion();
            self::assertSame("Do you like dog?", $actual);
            $exercise->setQuestion("");
            self::fail("例外が発生しませんでした。");
        } catch (DomainException $e) {
            self::assertSame("質問が空です。", $e->getMessage());
        }
    }

    public function testSetAnswer() {
        try {
            $exercise = Exercise::create("Do you like dog?", "yes, I like.");
            $actual = $exercise->getAnswer();
            self::assertSame("yes, I like.", $actual);
            $exercise->setAnswer("No, I don\'t.");
            $actual = $exercise->getAnswer();
            self::assertSame("No, I don\'t.", $actual);
        } catch (DomainException $e) {
            self::fail("予期しない例外が発生しました。" . $e);
        }
    }

    public function testSetAnswerWithEmpty() {
        try {
            $exercise = Exercise::create("Do you like dog?", "yes, I like.");
            $actual = $exercise->getAnswer();
            self::assertSame("yes, I like.", $actual);
            $exercise->setAnswer("");
            self::fail("例外が発生しませんでした。");
        } catch (DomainException $e) {
            self::assertSame("解答が空です。", $e->getMessage());
        }
    }
}
