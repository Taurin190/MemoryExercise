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
        $this->app->instance('Illuminate\Auth\Manager', $this->getAuthMock(false));
        $response = $this->actingAs($this->userMock)
            ->get(route('exercise.index'));
        $response->assertOk();
        $response->assertLocation("/exercise");
    }

    public function testList()
    {
        $response = $this->actingAs($this->userMock)
            ->get(route('exercise.list'));
        $response->assertOk();
        $response->assertLocation("/exercise/list");
    }

    public function testForm()
    {
        $response = $this->actingAs($this->userMock)
            ->get(route('exercise.form'));
        $response->assertOk();
        $response->assertLocation("/exercise/create");
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->userMock)
            ->post(route('exercise.create'));
        $response->assertOk();
        $response->assertLocation("/exercise/create");
    }

    protected function getAuthMock($isLoggedIn = false)
    {
        $authMock = m::mock('Illuminate\Auth\Manager');
        $authMock->shouldReceive('check')->once()->andReturn($isLoggedIn);
        return $authMock;
    }
}
