<?php

namespace Tests\Unit;

use Tests\TestCase;
use \Mockery as m;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
class ExerciseControllerTest extends TestCase
{
    protected $userMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->userMock = m::mock('\App\User')->makePartial();
        $this->userMock->shouldReceive("create")->andReturn("");
    }
    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
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

    public function testNotLogin()
    {
        $response = $this->get(route('exercise.index'));
        $response->assertStatus(302);
        $response->assertLocation("/login");
    }

    public function testIndex()
    {
        $user = factory(\App\User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('exercise.index'));
        $response->assertOk();
        $response->assertLocation("/exercise");
    }

    public function testList()
    {
        $response = $this->get(route('exercise.list'));
        $response->assertOk();
        $response->assertLocation("/exercise/list");
    }

    public function testForm()
    {
        $response = $this->get(route('exercise.form'));
        $response->assertOk();
        $response->assertLocation("/exercise/create");
    }

    public function testCreate()
    {
        $response = $this->post(route('exercise.create'));
        $response->assertOk();
        $response->assertLocation("/exercise/create");
    }
}
