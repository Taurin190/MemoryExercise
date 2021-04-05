<?php


namespace Tests\Feature\controller;


use Tests\TestCase;

class WorkbookControllerTest extends TestCase
{
    public function testList()
    {
        $user = factory(\App\User::class)->make();
        $response = $this->actingAs($user)->get(route('workbook.list'));
        $response->assertStatus(200);
    }

    public function testListWithoutLogin()
    {
        $response = $this->get(route('workbook.list'));
        $response->assertStatus(200);
    }

    /**
     * @dataProvider getTestDataForTestDetail
     */
    public function testDetail($uuid, $title)
    {
        $response = $this->get(route('workbook.detail', $uuid));
        $response->assertStatus(200);
        $response->assertSee($title);
    }

    public function testResult()
    {
        $user = factory(\App\User::class)->create();
        $response = $this->actingAs($user)->post(route('workbook.result', 'test2'), [
            'exercise_list' => [
                'exercise1',
                'exercise2'
            ],
            'answer' => [
                'exercise1' => 'ok',
                'exercise2' => 'ng'
            ]
        ]);
        $response->assertStatus(200);
    }

    public function getTestDataForTestDetail()
    {
        return [
            'workbook-1' => ['test1', 'test workbook1'],
            'workbook-2' => ['test2', 'test workbook2'],
        ];
    }
}
