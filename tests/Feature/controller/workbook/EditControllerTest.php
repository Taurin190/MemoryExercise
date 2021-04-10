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
}
