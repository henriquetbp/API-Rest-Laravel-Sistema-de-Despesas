<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       $required = "required";

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $required = "sometimes";
        }
        
        return [
            'description' => $required . '|max:191',
            'value' => $required . '|numeric|gt:0',
            'user_id' => $required . '|exists:App\Models\User,id|in:' . Auth::user()->id,
            'date' => $required . '|before_or_equal:today'
        ];
    }
}
