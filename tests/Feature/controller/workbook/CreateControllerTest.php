<?php


namespace Tests\Feature\controller\workbook;


use App\Workbook;
use Tests\TestCase;

class CreateControllerTest extends TestCase
{
    public function testShowCreate()
    {
        $user = factory(\App\User::class)->make();
        $response = $this->actingAs($user)->get(route('workbook.create'));
        $response->assertStatus(200);
    }

    public function testCreateWithoutUser()
    {
        $response = $this->get(route('workbook.create'));
        $response->assertStatus(302);
        $response->assertLocation('/login');
    }

    public function testConfirm()
    {
        $user = factory(\App\User::class)->create();
        $response = $this->actingAs($user)->post(route('workbook.confirm'), [
            'title' => 'test workbook 1',
            'explanation' => 'this is test workbook for test',
            'exercise_list' => ['exercise1', 'exercise2']
        ]);
        $response->assertStatus(200);
        $response->assertSessionHas('title_create');
        $response->assertSessionHas('explanation_create');
        $response->assertSessionHas('exercise_list_create');
        $user->delete();
    }

    public function testComplete()
    {
        $user = factory(\App\User::class)->create();
        $response = $this
            ->actingAs($user)
            ->withSession([
                'title_create' => 'test workbook 1',
                'explanation_create' => 'this is test workbook for test'
            ])
            ->post(route('workbook.complete'));
        $response->assertStatus(200);
        $response->assertSessionMissing('title_create');
        $response->assertSessionMissing('explanation_create');
        $response->assertSessionMissing('exercise_list_create');
        Workbook::where('title', 'test workbook 1')->delete();
        $user->delete();
    }
}
