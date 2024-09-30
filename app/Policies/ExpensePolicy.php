<?php

namespace App\Policies;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

class ExpensePolicy
{
    public function show(User $user, Expense $expense): bool
    {
        return $user->id == $expense->user_id;
    }

    public function update(User $user, Expense $expense): bool
    {
        return $user->id == $expense->user_id;
    }

    public function delete(User $user, Expense $expense): bool
    {
        return $user->id == $expense->user_id;
    }

}
