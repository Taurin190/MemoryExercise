<?php


namespace Tests\Feature\controller\exercise;


use Tests\TestCase;

class DeleteControllerTest extends TestCase
{
    public function testDeleteComplete()
    {
        $user = factory(\App\User::class)->create();
        $exercise = factory(\App\Exercise::class)->create([
            'author_id' => $user->getKey()
        ]);
        $id = $exercise->getKey();
        $response = $this->actingAs($user)->post(route('exercise.delete.complete', $id));
        $response->assertStatus(200);
        $user->delete();
    }

    public function testDeleteCompleteWithInvalidUser()
    {
        $user = factory(\App\User::class)->create();
        $exercise = factory(\App\Exercise::class)->create([
            'author_id' => 10
        ]);
        $id = $exercise->getKey();
        $response = $this->actingAs($user)->post(route('exercise.delete.complete', $id));
        $response->assertStatus(403);
        $exercise->delete();
        $user->delete();
    }

    public function testDeleteCompleteWithInvalidId()
    {
        $user = factory(\App\User::class)->create();
        $response = $this->actingAs($user)->post(route('exercise.delete.complete', 'test999'));
        $response->assertStatus(404);
        $user->delete();
    }
}
