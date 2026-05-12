<?php

use App\Models\Task;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;
use function Pest\Laravel\delete;

test('guest are redirected to login when visiting tasks page', function (): void {
    get('/tasks')
        ->assertRedirect('/login');
});

test('authenticated users can visit tasks page', function (): void {
    $user = User::factory()->create();

    actingAs($user);

    get('/tasks')
        ->assertOk()
        ->assertSeeText('My Tasks');
});

test('authenticated users can create a task', function (): void {
    $user = User::factory()->create();

    actingAs($user);

    post('/tasks', [
        'title' => 'Buy groceries',
    ])->assertRedirect('/tasks');
    $this->assertDatabaseHas('tasks', [
        'user_id' => $user->id,
        'title' => 'Buy groceries',
    ]);
});

test('task title is required', function (): void {
    $user = User::factory()->create();

    actingAs($user);

    from('/tasks')->post('/tasks', [
        'title' => '',
    ])->assertRedirect('/tasks')->assertInvalid(['title']);
});

test('authenticated users can see their own task titles', function (): void {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    Task::factory()->create(['user_id' => $user->id, 'title' => 'My Task']);
    Task::factory()->create(['user_id' => $otherUser->id, 'title' => 'Not My Task']);

    actingAs($user);

    get('/tasks')
        ->assertOk()
        ->assertSeeText('My Task')
        ->assertDontSeeText('Not My Task');

});

test('authenticated users can mark their task as completed', function (): void {
    $user = User::factory()->create();

    $task = Task::factory()->create([
        'user_id' => $user->id,
        'is_completed' => false,
    ]);

    actingAs($user);

    patch("/tasks/{$task->id}", [
        'is_completed' => true,
    ])->assertRedirect('/tasks');

    expect($task->fresh()->is_completed)->toBeTrue();

});

test('authenticated users cannot mark another users task as completed', function (): void {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $task = Task::factory()->create([
        'user_id' =>$otherUser->id,
        'is_completed' => false,
    ]);

    actingAs($user);

    patch("/tasks/{$task->id}",[
        'is_completed' => true,
    ])->assertForbidden();

    expect($task->fresh()->is_completed)->toBeFalse();
});

test('authenticated users can delete their own task', function (): void {
    $user = User::factory()->create();

    $task = Task::factory()->create([
        'user_id' => $user->id,
    ]);

    actingAs($user);

    delete("/tasks/{$task->id}")
        ->assertRedirect('/tasks');

    $this->assertModelMissing($task);
});


test('authenticated users cannot delete another users task', function (): void {
   $user = User::factory()->create();
   $otherUser = User::factory()->create();

   $task = Task::factory()->create([
       'user_id' => $otherUser->id,
   ]);

   actingAs($user);

   delete("/tasks/{$task->id}")
       ->assertForbidden();

   $this->assertModelExists($task);
});
