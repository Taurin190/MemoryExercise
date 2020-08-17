<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/08/17
 * Time: 9:01
 */

namespace Tests\Unit\domain;
use Tests\TestCase;
use App\Domain\Label;
use \Mockery as m;

class LabelTest extends TestCase
{
    protected $labelMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->labelMock = m::mock('\App\Label');
    }
    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }

    public function testCreate() {
        $actual = Label::create('test');
        self::assertTrue($actual instanceof Label);
        self::assertSame("test", $actual->getName());
    }
    public function testMap() {
        $this->labelMock->shouldReceive('getKey')
            ->once()->with()->andReturn(1);
        $this->labelMock->shouldReceive('getAttribute')
            ->once()->with('name')->andReturn('test');
        $actual = Label::map($this->labelMock);
        self::assertTrue($actual instanceof Label);
        self::assertSame("test", $actual->getName());
        self::assertSame(1, $actual->getLabelId());
    }
}
