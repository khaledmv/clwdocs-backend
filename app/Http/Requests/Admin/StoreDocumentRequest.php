<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
      return [
            'title'                  => ['required', 'string', 'max:255'],
            'meta_title'             => ['nullable', 'string'],
            'meta_description'       => ['nullable', 'string'],
            'description'            => ['nullable', 'string'],
            'document_type_ids'      => ['nullable', 'array'],
            'document_type_ids.*'    => ['exists:document_types,id'],
            'brand_ids'              => ['nullable', 'array'],
            'brand_ids.*'            => ['exists:brands,id'],
            'application_ids'        => ['nullable', 'array'],
            'application_ids.*'      => ['exists:applications,id'],
            'solution_ids'           => ['nullable', 'array'],
            'solution_ids.*'         => ['exists:solutions,id'],
            'product_category_ids'   => ['nullable', 'array'],
            'product_category_ids.*' => ['exists:product_categories,id'],
            'location_ids'           => ['nullable', 'array'],
            'location_ids.*'         => ['exists:locations,id'],
            'file'                   => ['required', 'file', 'max:51200'],
            'thumbnail'           => ['nullable', 'image', 'max:2048'],
            'is_published'        => ['boolean'],
        ];
    }
}
