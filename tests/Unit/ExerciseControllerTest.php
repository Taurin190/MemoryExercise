<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\ExerciseController;

class ExerciseControllerTest extends TestCase
{
    private $ExerciseController;

    public function setUp(): void
    {
        parent::setUp();
        $this->ExerciseController = new ExerciseController();
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testIndex()
    {
        $actual = $this->ExerciseController->index();
        $this->assertSame(view("exercise_index"), $actual);
    }

    public function testList()
    {
        $actual = $this->ExerciseController->list();
        $this->assertSame(view("exercise_list"), $actual);
    }

    public function testForm()
    {
        $actual = $this->ExerciseController->form();
        $this->assertSame(view("exercise_form"), $actual);
    }

    public function testCreate()
    {
        $actual = $this->ExerciseController->create();
        $this->assertSame(view("exercise_create"), $actual);
    }
}
