<?php


namespace Tests\Feature\controller\exercise;


use App\Exercise;
use Tests\TestCase;

class CreateControllerTest extends TestCase
{
    public function testShowCreate()
    {
        $user = factory(\App\User::class)->make();
        $response = $this->actingAs($user)->get(route('exercise.create'));
        $response->assertStatus(200);
    }

    public function testCreateWithoutUser()
    {
        $response = $this->get(route('exercise.create'));
        $response->assertStatus(302);
        $response->assertLocation('/login');
    }

    public function testConfirm()
    {
        $user = factory(\App\User::class)->create();
        $response = $this->actingAs($user)->post(route('exercise.confirm'), [
            'question' => 'Is this test question',
            'answer' => 'Yes, it is.',
            'permission' => 1
        ]);
        $response->assertStatus(200);
        $response->assertSessionHas('question_create');
        $response->assertSessionHas('answer_create');
        $response->assertSessionHas('permission_create');
        $user->delete();
    }

    public function testComplete()
    {
        $user = factory(\App\User::class)->create();
        $response = $this
            ->actingAs($user)
            ->withSession([
                'question_create' => 'Is this test question',
                'answer_create' => 'Yes, it is.',
                'permission_create' => 1,
                'label_create'
            ])
            ->post(route('exercise.complete'));
        $response->assertStatus(200);
        $response->assertSessionMissing('question_create');
        $response->assertSessionMissing('answer_create');
        $response->assertSessionMissing('permission_create');
        Exercise::where('question', 'Is this test question')->delete();
        $user->delete();
    }
}
