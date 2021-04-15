<?php

namespace Tests\Unit\domain;

use App\Domain\DateExerciseCount;
use Tests\TestCase;

class DateExerciseCountTest extends TestCase
{
    public function testAccessProperties()
    {
        $date = new \DateTime('2020-01-01T12:00:01');
        $actual = new DateExerciseCount($date, 10);
        self::assertTrue($actual['date'] instanceof \DateTime);
        self::assertSame(10, $actual['count']);
    }

    public function testOffsetExists()
    {
        $date = new \DateTime('2020-01-01T12:00:01');
        $actual = new DateExerciseCount($date, 10);
        self::assertTrue($actual->offsetExists('date'));
        self::assertFalse($actual->offsetExists('invalid'));
    }

    public function testNotSetProperties()
    {
        $date = new \DateTime('2020-01-01T12:00:01');
        $actual = new DateExerciseCount($date, 10);
        $actual['count'] = 20;
        self::assertSame(10, $actual['count']);
    }

    public function testNotUnSetProperties()
    {
        $date = new \DateTime('2020-01-01T12:00:01');
        $actual = new DateExerciseCount($date, 10);
        unset($actual['count']);
        self::assertSame(10, $actual['count']);
    }
}
