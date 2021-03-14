<?php

namespace Tests\Unit\domain;
use Tests\TestCase;
use App\Domain\Exercise;
use App\Domain\DomainException;
use \Mockery as m;

class ExerciseTest extends TestCase
{
    protected $exerciseModelMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->exerciseModelMock = m::mock('\App\Exercise');
    }
    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }

    public function testCreate() {
        try {
            $exercise = Exercise::create(["question" => "Do you like dog?", "answer" => "yes, I like."]);
            $actual = $exercise->getExerciseDto();
            self::assertSame("Do you like dog?", $actual->question);
            self::assertSame("yes, I like.", $actual->answer);
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。" . $e);
        }
    }

    public function testCreateWithoutQuestion() {
        try {
            Exercise::create(["answer" => "yes, I like."]);
            self::fail("例外が発生しませんでした。");
        } catch (DomainException $e) {
            self::assertSame("質問が空です。", $e->getMessage());
        }
    }

    public function testCreateWithoutAnswer() {
        try {
            Exercise::create(["question" => "Do you like dog?"]);
            self::fail("例外が発生しませんでした。");
        } catch (DomainException $e) {
            self::assertSame("解答が空です。", $e->getMessage());
        }
    }

    public function testCreateWithoutPermission() {
        try {
            $exercise = Exercise::create(["question" => "Do you like dog?", "answer" => "yes, I like."]);
            $actual = $exercise->getExerciseDto();
            self::assertSame(1, $actual->permission);
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。" . $e);
        }
    }
    public function testCreateWithPrivatePermission() {
        try {
            $exercise = Exercise::create([
                "question" => "Do you like dog?",
                "answer" => "yes, I like.",
                "permission" => 0
            ]);
            $actual = $exercise->getExerciseDto();
            self::assertSame(0, $actual->permission);
        } catch (\Exception $e) {
            self::fail("予期しない例外が発生しました。" . $e);
        }
    }

    public function testConvertDomain()
    {
        $this->exerciseModelMock
            ->shouldReceive('getKey')
            ->once()
            ->andReturn(1);
        $this->exerciseModelMock
            ->shouldReceive('getAttribute')
            ->with('question')
            ->once()
            ->andReturn('Is this an apple?');
        $this->exerciseModelMock
            ->shouldReceive('getAttribute')
            ->with('answer')
            ->once()
            ->andReturn('Yes, it is.');
        $this->exerciseModelMock
            ->shouldReceive('getAttribute')
            ->with('permission')
            ->once()
            ->andReturn(1);
        $this->exerciseModelMock
            ->shouldReceive('getAttribute')
            ->with('label_list')
            ->once()
            ->andReturn([]);
        $this->exerciseModelMock
            ->shouldReceive('getAttribute')
            ->with('author_id')
            ->once()
            ->andReturn(1);
        $actual = Exercise::convertDomain($this->exerciseModelMock)->getExerciseDto();
        self::assertSame(1, $actual->exercise_id);
        self::assertSame('Is this an apple?', $actual->question);
        self::assertSame('Yes, it is.', $actual->answer);
    }

    public function testToArray() {
        try {
            $exercise = Exercise::create(["question" => "Do you like dog?", "answer" => "yes, I like."]);
            $actual = $exercise->toArray();
            self::assertSame([
                "exercise_id" => null,
                "question" => "Do you like dog?",
                "answer" => "yes, I like."
            ],$actual);
        } catch (DomainException $e) {
            self::fail("予期しない例外が発生しました。" . $e);
        }
    }
}
