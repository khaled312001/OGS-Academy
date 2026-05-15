<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'min:2', 'max:120'],
            'email'     => ['required', 'email', 'max:160'],
            'phone'     => ['nullable', 'string', 'max:32'],
            'subject'   => ['nullable', 'string', 'max:160'],
            'message'   => ['required', 'string', 'min:8', 'max:5000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'full_name' => 'الاسم الكامل',
            'email'     => 'البريد الإلكتروني',
            'phone'     => 'رقم الجوال',
            'subject'   => 'الموضوع',
            'message'   => 'الرسالة',
        ];
    }
}
