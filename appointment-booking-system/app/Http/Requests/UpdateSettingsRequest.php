<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
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
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'business_name' => 'required|string|max:255',
            'business_phone' => 'nullable|string|max:50',
            'business_email' => 'nullable|email',
            'business_address' => 'nullable|string',
            'business_description' => 'nullable|string',
            'opening_time' => 'nullable|string',
            'closing_time' => 'nullable|string',
            'appointment_slot_duration' => 'required|integer|min:5',
            'currency' => 'required|string|max:10',
            'timezone' => 'required|string|max:100',
        ];
    }
}
