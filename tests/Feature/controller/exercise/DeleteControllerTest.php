<?php


namespace Tests\Feature\controller\exercise;


use Tests\TestCase;

class DeleteControllerTest extends TestCase
{
    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(\App\User::class)->create();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->user->delete();
    }

    public function testDeleteComplete()
    {
        $exercise = factory(\App\Exercise::class)->create([
            'author_id' => $this->user->getKey()
        ]);
        $id = $exercise->getKey();
        $response = $this->actingAs($this->user)->post(route('exercise.delete.complete', $id));
        $response->assertStatus(200);
    }

    public function testDeleteCompleteWithInvalidUser()
    {
        $exercise = factory(\App\Exercise::class)->create([
            'author_id' => 10
        ]);
        $id = $exercise->getKey();
        $response = $this->actingAs($this->user)->post(route('exercise.delete.complete', $id));
        $response->assertStatus(403);
        $exercise->delete();
    }

    public function testDeleteCompleteWithInvalidId()
    {
        $response = $this->actingAs($this->user)->post(route('exercise.delete.complete', 'test999'));
        $response->assertStatus(404);
    }
}
