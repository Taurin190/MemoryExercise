<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/07/28
 * Time: 21:41
 */

namespace Tests\Unit\domain;
use Tests\TestCase;
use App\domain\Answer;
use \Mockery as m;

class AnswerTest extends TestCase
{
    protected $requestMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->requestMock = m::mock('Illuminate\Http\Request');
    }

    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }

    public function testGetExerciseCount() {
        $this->requestMock->exercise_list = ['test1', 'test2', 'test3'];
        $this->requestMock->test1 = 'ok';
        $this->requestMock->test2 = 'ng';
        $this->requestMock->test3 = 'studying';

        $answer = new Answer($this->requestMock);
        self::assertSame(3, $answer->getExerciseCount());
    }

    public function testGetOKCount() {
        $this->requestMock->exercise_list = ['test1', 'test2', 'test3'];
        $this->requestMock->test1 = 'ok';
        $this->requestMock->test2 = 'ng';
        $this->requestMock->test3 = 'studying';

        $answer = new Answer($this->requestMock);
        self::assertSame(1, $answer->getOKCount());
    }

    public function testGetNGCount() {
        $this->requestMock->exercise_list = ['test1', 'test2', 'test3'];
        $this->requestMock->test1 = 'ok';
        $this->requestMock->test2 = 'ng';
        $this->requestMock->test3 = 'studying';

        $answer = new Answer($this->requestMock);
        self::assertSame(1, $answer->getNGCount());
    }

    public function testGetStudyingCount() {
        $this->requestMock->exercise_list = ['test1', 'test2', 'test3'];
        $this->requestMock->test1 = 'ok';
        $this->requestMock->test2 = 'ng';
        $this->requestMock->test3 = 'studying';

        $answer = new Answer($this->requestMock);
        self::assertSame(1, $answer->getStudyingCount());
    }
}
