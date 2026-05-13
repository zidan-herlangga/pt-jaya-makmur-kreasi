<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Public form
    }

    public function rules(): array
    {
        return [
            'product_id' => ['nullable', 'exists:advertising_points,id'],
            'sender_name' => ['required', 'string', 'max:150'],
            'sender_email' => ['required', 'email', 'max:150'],
            'sender_phone' => ['nullable', 'string', 'max:20'],
            'company_name' => ['nullable', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:5000'],
            'website' => ['nullable', 'max:0'], // Honeypot field - must be empty
        ];
    }

    public function attributes(): array
    {
        return [
            'sender_name' => 'Nama Lengkap',
            'sender_email' => 'Email',
            'sender_phone' => 'Nomor Telepon',
            'company_name' => 'Nama Perusahaan',
            'message' => 'Pesan',
        ];
    }

    public function messages(): array
    {
        return [
            'website.max' => 'Spam detected.',
        ];
    }

    public function passedValidation(): void
    {
        // Mark as spam if honeypot is filled
        if ($this->filled('website')) {
            $this->merge(['status' => 'spam']);
        }
    }
}
