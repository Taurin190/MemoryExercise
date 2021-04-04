<?php


namespace Tests\Feature\controller;


use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    public function testHome()
    {
        $user = factory(\App\User::class)->make();
        $response = $this->actingAs($user)->get(route('index'));
        $response->assertStatus(200);
    }

    public function testIndex()
    {
        $response = $this->get(route('index'));
        $response->assertStatus(200);
    }
}
