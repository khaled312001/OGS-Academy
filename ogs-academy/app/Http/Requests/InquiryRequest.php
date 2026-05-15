<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'program_id'      => ['nullable', 'integer', 'exists:programs,id'],
            'full_name'       => ['required', 'string', 'min:2', 'max:120'],
            'company'         => ['required', 'string', 'min:2', 'max:160'],
            'job_title'       => ['required', 'string', 'min:2', 'max:160'],
            'email'           => ['required', 'email', 'max:160'],
            'phone'           => ['required', 'string', 'min:7', 'max:32'],
            'trainees_count'  => ['nullable', 'integer', 'min:1', 'max:1000'],
            'preferred_date'  => ['nullable', 'string', 'max:60'],
            'message'         => ['nullable', 'string', 'max:5000'],
            'source'          => ['nullable', 'string', 'max:60'],
        ];
    }

    public function attributes(): array
    {
        return [
            'full_name'      => 'الاسم الكامل',
            'company'        => 'الشركة',
            'job_title'      => 'المسمى الوظيفي',
            'email'          => 'البريد الإلكتروني',
            'phone'          => 'رقم الجوال',
            'trainees_count' => 'عدد المتدربين',
            'preferred_date' => 'التاريخ المفضّل',
            'message'        => 'تفاصيل إضافية',
        ];
    }
}
