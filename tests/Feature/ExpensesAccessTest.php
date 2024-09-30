<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpensesAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_get_all_expenses()
    {
        $this->seed();

        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->getJson('/api/expenses');

        $response->assertStatus(200);
        $this->assertEquals(10, count($response->getData()->data));
    }

    public function test_user_can_access_expense()
    {
        $this->seed();

        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->getJson('/api/expenses/10');

        $response->assertStatus(200);
    }

    public function test_block_expense_from_another_user()
    {
        $this->seed();

        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->getJson('/api/expenses/11');

        $response->assertStatus(403);
    }

    public function test_user_can_create_expense()
    {
        $this->seed();

        $user = User::find(1);
        $this->actingAs($user);
        
        $response = $this->postJson('/api/expenses', [
            'description' => 'expense 1',
            'value' => 100,
            'date' => '2024-01-01',
            'user_id' => $user->id
        ]);

        $response->assertStatus(200);
    }

    public function test_block_create_expense_to_another_user()
    {
        $this->seed();

        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->postJson('/api/expenses', [
            'description' => 'expense 1',
            'value' => 100,
            'date' => '2024-01-01',
            'user_id' => 2
        ]);

        $response->assertStatus(422);
    }

    public function test_user_can_update_expense()
    {
        $this->seed();

        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->putJson('/api/expenses/1', [
            'description' => 'expense 1 updated',
            'value' => 200,
            'date' => '2024-01-01',
        ]);

        $response->assertStatus(200);
    }

    public function test_block_update_expense_from_another_user()
    {
        $this->seed();

        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->putJson('/api/expenses/11', [
            'description' => 'expense 1 updated',
            'value' => 200,
            'date' => '2024-01-01',
        ]);
        
        $response->assertStatus(403);
    }

    public function test_user_can_delete_expense()
    {
        $this->seed();

        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->deleteJson('/api/expenses/1');
        
        $response->assertStatus(200);
    }

    public function test_block_delete_expense_from_another_user()
    {
        $this->seed();

        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->deleteJson('/api/expenses/11');
        
        $response->assertStatus(403);
    }
}