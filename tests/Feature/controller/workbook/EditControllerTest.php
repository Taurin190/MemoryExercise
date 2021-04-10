<?php


namespace Tests\Feature\controller\workbook;


use Tests\TestCase;

class EditControllerTest extends TestCase
{
    public function testShowEdit()
    {
        $user = factory(\App\User::class)->make(['id' => 10]);
        $response = $this->actingAs($user)->get(route('workbook.edit', 'test1'));
        $response->assertStatus(200);
    }

    public function testCreateWithoutUser()
    {
        $response = $this->get(route('workbook.edit', 'test1'));
        $response->assertStatus(302);
        $response->assertLocation('/login');
    }

    public function testCreateWithInvalidId()
    {
        $user = factory(\App\User::class)->make(['id' => 10]);
        $response = $this->actingAs($user)->get(route('workbook.edit', 'test999'));
        $response->assertStatus(404);
    }

    public function testCreateWithoutPermission()
    {
        $user = factory(\App\User::class)->make(['id' => 15]);
        $response = $this->actingAs($user)->get(route('workbook.edit', 'test1'));
        $response->assertStatus(403);
    }

    public function testConfirm()
    {
        $user = factory(\App\User::class)->create();
        $workbook = factory(\App\Workbook::class)->create([
            'author_id' => $user->getKey()
        ]);
        $id = $workbook->getKey();
        $response = $this->actingAs($user)->post(route('workbook.edit.confirm', $id), [
            'title' => 'this is modified test title',
            'explanation' => 'this is modified test explanation',
        ]);
        $response->assertStatus(200);
        $response->assertSessionHas('title_edit');
        $response->assertSessionHas('explanation_edit');
        $response->assertSessionHas('exercise_list_edit');
        $workbook->delete();
        $user->delete();
    }

    public function testComplete()
    {
        $user = factory(\App\User::class)->create();
        $workbook = factory(\App\Workbook::class)->create([
            'author_id' => $user->getKey()
        ]);
        $id = $workbook->getKey();
        $response = $this
            ->actingAs($user)
            ->withSession([
                'title_edit' => 'this is modified test title',
                'explanation_edit' => 'this is modified test explanation'
            ])
            ->post(route('workbook.edit.complete', $id));
        $response->assertStatus(200);
        $response->assertSessionMissing('title_edit');
        $response->assertSessionMissing('explanation_edit');
        $response->assertSessionMissing('exercise_list_edit');
        $workbook->delete();
        $user->delete();
    }
}
