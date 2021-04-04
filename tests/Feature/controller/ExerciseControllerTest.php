<?php


namespace Tests\Feature\controller;


use Tests\TestCase;

class ExerciseControllerTest extends TestCase
{
    /**
     * @dataProvider getTestDataForTestDetail
     */
    public function testDetail($uuid, $title)
    {
        $user = factory(\App\User::class)->make();
        $response = $this->actingAs($user)->get(route('exercise.detail', $uuid));
        $response->assertStatus(200);
        $response->assertSee($title);
    }

    public function testListWithAuth()
    {
        $user = factory(\App\User::class)->make();
        $response = $this->actingAs($user)->get(route('exercise.list'));
        $response->assertStatus(200);
    }

    public function testListWithoutAuth()
    {
        $response = $this->get(route('exercise.list'));
        $response->assertStatus(200);
    }

    public function getTestDataForTestDetail()
    {
        return [
            'exercise-1' => ['exercise1', 'Is this a dog?'],
            'exercise-2' => ['exercise2', 'Is this a cat?'],
        ];
    }
}
