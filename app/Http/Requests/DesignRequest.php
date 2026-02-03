<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DesignRequest extends FormRequest
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

            'design_entry_date' => 'required|date',
            'product_name' => 'required|string|max:255',
            'design_name' => 'required|string|max:255',
            'material_setup_id' => 'required|exists:material_setups,id',
            'design_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable',
            'remarks' => 'nullable',
        ];
    }
}
