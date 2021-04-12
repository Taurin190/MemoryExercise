<?php


namespace Tests\Feature\controller\workbook;


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
        $workbook = factory(\App\Workbook::class)->create([
            'author_id' => $this->user->getKey()
        ]);
        $id = $workbook->getKey();
        $response = $this->actingAs($this->user)->post(route('workbook.delete.complete', $id));
        $response->assertStatus(200);
    }

    public function testDeleteCompleteWithInvalidUser()
    {
        $workbook = factory(\App\Workbook::class)->create([
            'author_id' => 10
        ]);
        $id = $workbook->getKey();
        $response = $this->actingAs($this->user)->post(route('workbook.delete.complete', $id));
        $response->assertStatus(403);
        $workbook->delete();
    }

    public function testDeleteCompleteWithInvalidId()
    {
        $response = $this->actingAs($this->user)->post(route('workbook.delete.complete', 'test999'));
        $response->assertStatus(404);
    }
}
