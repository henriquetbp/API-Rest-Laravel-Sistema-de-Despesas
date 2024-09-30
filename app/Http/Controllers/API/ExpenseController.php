<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\ExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Models\User;
use App\Notifications\ExpenseCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ExpenseController extends BaseController
{

    public function index()
    {
        $user_id = Auth::user()->id;
        $expense = Expense::where('user_id', $user_id)->get();
        return $this->sendResponse(ExpenseResource::collection($expense), 'Despesas recebidas com sucesso.');
    }

    public function store(ExpenseRequest $request)
    {
        $expense = Expense::create($request->all());
        $user = User::find($request->user_id);
        $user->notify(new ExpenseCreatedNotification($expense));
        return $this->sendResponse(new ExpenseResource($expense), 'Despesa criada com sucesso.');
    }

    public function show(Expense $expense)
    {
        if(!Gate::allows('show', $expense)){
            return $this->sendError('Usuário sem permissão.');
        }

        if(is_null($expense)) {
            return $this->sendError('Nenhuma despesa encontrada');
        }

        return $this->sendResponse(new ExpenseResource($expense), 'Despesa encontrada com sucesso.');
    }

    public function update(ExpenseRequest $request, Expense $expense)
    {
        if(!Gate::allows('update', $expense)){
            return $this->sendError('Usuário sem permissão.');
        }

        $expense->update($request->all());
        return $this->sendResponse(new ExpenseResource($expense), 'Despesa atualizada com sucesso.');

    }

    public function destroy(Expense $expense)
    {
        if(!Gate::allows('delete', $expense)){
            return $this->sendError('Usuário sem permissão.');
        }

        $expense->delete();
        return $this->sendResponse([], 'Despesa excluída com sucesso');
    }
}
