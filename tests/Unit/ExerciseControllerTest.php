<?php

namespace Tests\Unit;

use Tests\TestCase;
use \Mockery as m;
use Illuminate\Auth as auth;
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

    public function testList()
    {
        $response = $this->actingAs($this->userMock)
            ->get(route('exercise.list'));
        $response->assertOk();
    }

    public function testForm()
    {
        $response = $this->actingAs($this->userMock)
            ->get(route('exercise.create'));
        $response->assertOk();
    }

    protected function getAuthMock($isLoggedIn = false)
    {
        $authMock = m::mock('Illuminate\Auth\AuthManager');
        $authMock->shouldReceive('check')->once()->andReturn($isLoggedIn);
        $authMock->shouldReceive('shouldUse')->once()->andReturn();
        return $authMock;
    }
}
