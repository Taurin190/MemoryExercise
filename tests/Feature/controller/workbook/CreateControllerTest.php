<?php


namespace Tests\Feature\controller\workbook;


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
}
