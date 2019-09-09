<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class TodoTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->user = factory(App\User::class)->create();
    }

    public function testHome()
    {
        $this->actingAs($this->user)
            ->visit('/home')
            ->see('To Do List')
            ->see('Add')
            ->see('Delete Selected');
    }

    public function testIndexTodo()
    {
        $response = $this->call('GET', '/todos', ['userId' => $this->user->id]);

        $this->assertEquals(200, $response->status());
    }

    public function testAddTodo()
    {
        $response = $this->call('POST', '/todos', ['todo' => 'Drink', 'userId' => $this->user->id]);

        $this->assertEquals(201, $response->status());
        $this->seeInDatabase('todos', ['todo' => 'Drink']);
    }

    public function testUpdateTodo()
    {
        $todo = factory(App\Todo::class)->create();

        $response = $this->call('PATCH', '/todos/' . $todo->id, ['isChecked' => 'true']);

        $this->assertEquals(200, $response->status());
        $this->seeInDatabase('todos', ['is_done' => 1]);
    }

    public function testDeleteTodo()
    {
        $todo = factory(App\Todo::class)->create();

        $response = $this->call('DELETE', '/todos/' . $todo->id);

        $this->assertEquals(200, $response->status());
        $this->dontSeeInDatabase('todos', ['id' => $todo->id]);
    }

    public function testDeleteSelectedTodo()
    {
        $todo = factory(App\Todo::class)->create(['user_id' => $this->user->id]);

        $response = $this->call('DELETE', '/todos/' . $todo->id . '/delete-selected', ['ids' => [$todo->id], 'userId' => $this->user->id]);

        $this->assertEquals(200, $response->status());
        $this->dontSeeInDatabase('todos', ['id' => $todo->id]);
    }
}
