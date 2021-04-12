<?php


namespace Tests\Feature\controller\workbook;


use App\Workbook;
use Tests\TestCase;

class CreateControllerTest extends TestCase
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

    public function testShowCreate()
    {
        $response = $this->actingAs($this->user)->get(route('workbook.create'));
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
        $response = $this->actingAs($this->user)->post(route('workbook.confirm'), [
            'title' => 'test workbook 1',
            'explanation' => 'this is test workbook for test',
            'exercise_list' => ['exercise1', 'exercise2']
        ]);
        $response->assertStatus(200);
        $response->assertSessionHas('title_create');
        $response->assertSessionHas('explanation_create');
        $response->assertSessionHas('exercise_list_create');
    }

    public function testComplete()
    {
        $response = $this
            ->actingAs($this->user)
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
    }
}
