<?php

namespace Tests\Unit\domain;
use Tests\TestCase;
use App\Domain\Exercise;
use App\Domain\DomainException;
use \Mockery as m;

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


}
