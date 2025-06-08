<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreMoodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check(); // Ensure the user is authenticated
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'emoji' => 'required|string|max:255',
            'note' => 'nullable|string|max:1000',
            'rating' => 'nullable|integer|min:1|max:10',
            'user_id' => 'required|exists:users,id', // Ensure user_id exists in users table
        ];
    }
}
