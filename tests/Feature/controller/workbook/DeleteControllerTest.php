<?php


namespace Tests\Feature\controller\workbook;


use Tests\TestCase;

class DeleteControllerTest extends TestCase
{
    public function testDeleteComplete()
    {
        $user = factory(\App\User::class)->create();
        $workbook = factory(\App\Workbook::class)->create([
            'author_id' => $user->getKey()
        ]);
        $id = $workbook->getKey();
        $response = $this->actingAs($user)->post(route('workbook.delete.complete', $id));
        $response->assertStatus(200);
        $user->delete();
    }

    public function testDeleteCompleteWithInvalidUser()
    {
        $user = factory(\App\User::class)->create();
        $workbook = factory(\App\Workbook::class)->create([
            'author_id' => 10
        ]);
        $id = $workbook->getKey();
        $response = $this->actingAs($user)->post(route('workbook.delete.complete', $id));
        $response->assertStatus(403);
        $workbook->delete();
        $user->delete();
    }

    public function testDeleteCompleteWithInvalidId()
    {
        $user = factory(\App\User::class)->create();
        $response = $this->actingAs($user)->post(route('workbook.delete.complete', 'test999'));
        $response->assertStatus(404);
        $user->delete();
    }
}
