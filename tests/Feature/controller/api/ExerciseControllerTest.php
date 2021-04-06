<?php


namespace Tests\Feature\controller\api;


use Tests\TestCase;

class ExerciseControllerTest extends TestCase
{
    public function testSearch()
    {
        $user = factory(\App\User::class)->create(['api_token' => 'test-token']);
        $response = $this->actingAs($user)->get('/api/exercise');
        $response->assertStatus(200);
        $user->delete();
    }

    public function testList()
    {
        $user = factory(\App\User::class)->create(['api_token' => 'test-token']);
        $response = $this->actingAs($user)->get('/api/exercise/list');
        $response->assertStatus(200);
        $user->delete();
    }
}
