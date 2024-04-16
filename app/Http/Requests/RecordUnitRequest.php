<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecordUnitRequest extends ValidationRequest
{

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
            'ticket_id' => ['required', Rule::exists('tickets', 'id')],
            'site_id' => ['required', Rule::exists('sites', 'id')],
            'identifier' => ['required', 'string', Rule::unique('units', 'units')],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'specification' => ['required', 'string'],
            'photo.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'excel.*' => 'nullable|image|mimes:csv,xlsx,xls|max:20480'
        ];
    }
}
