<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class CreateInquiryRequest extends ValidationRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'information' => 'required|string',
            'site_id' => 'required|exists:sites,id',
            'photo.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240'
        ];
    }
}
