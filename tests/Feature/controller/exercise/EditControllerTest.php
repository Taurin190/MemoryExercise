<?php


namespace Tests\Feature\controller\exercise;


use App\Exercise;
use Tests\TestCase;

class EditControllerTest extends TestCase
{
    public function testShowEdit()
    {
        $user = factory(\App\User::class)->make(['id' => 10]);
        $response = $this->actingAs($user)->get(route('exercise.edit', 'exercise1'));
        $response->assertStatus(200);
    }

    public function testCreateWithoutUser()
    {
        $response = $this->get(route('exercise.edit', 'test1'));
        $response->assertStatus(302);
        $response->assertLocation('/login');
    }

    public function testCreateWithInvalidId()
    {
        $user = factory(\App\User::class)->make(['id' => 10]);
        $response = $this->actingAs($user)->get(route('exercise.edit', 'exercise999'));
        $response->assertStatus(404);
    }

    public function testCreateWithoutPermission()
    {
        $user = factory(\App\User::class)->make(['id' => 15]);
        $response = $this->actingAs($user)->get(route('exercise.edit', 'exercise1'));
        $response->assertStatus(403);
    }

    public function testConfirm()
    {
        $user = factory(\App\User::class)->create();
        $exercise = factory(\App\Exercise::class)->create([
            'author_id' => $user->getKey()
        ]);
        $id = $exercise->getKey();
        $response = $this->actingAs($user)->post(route('exercise.edit.confirm', $id), [
            'question' => 'Is this modified test question',
            'answer' => 'Yes, it is modified one',
        ]);
        $response->assertStatus(200);
        $response->assertSessionHas('question_edit');
        $response->assertSessionHas('answer_edit');
        $response->assertSessionHas('permission_edit');
        $exercise->delete();
        $user->delete();
    }

    public function testComplete()
    {
        $user = factory(\App\User::class)->create();
        $exercise = factory(Exercise::class)->create([
            'author_id' => $user->getKey()
        ]);
        $id = $exercise->getKey();
        $response = $this
            ->actingAs($user)
            ->withSession([
                'question_edit' => 'Is this modified test question',
                'answer_edit' => 'Yes, it is.',
                'permission_edit' => 1,
                'label_edit'
            ])
            ->post(route('exercise.edit.complete', $id));
        $response->assertStatus(200);
        $response->assertSessionMissing('question_edit');
        $response->assertSessionMissing('answer_edit');
        $response->assertSessionMissing('permission_edit');
        Exercise::where('question', 'Is this modified test question')->delete();
        $user->delete();
    }
}
