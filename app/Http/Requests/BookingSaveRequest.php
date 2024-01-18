<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingSaveRequest extends FormRequest
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
        return [
            'car_park_space_id' => 'required|exists:car_park_spaces,id',
            'customer_id' => 'required|exists:customers,id',
            'start' => 'required|date|before:end|after_or_equal:tomorrow',
            'end' => 'required|date|after_or_equal:start',
        ];
    }
}
