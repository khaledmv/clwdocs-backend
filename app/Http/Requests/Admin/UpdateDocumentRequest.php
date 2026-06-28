<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDocumentRequest extends FormRequest
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
            'title'               => ['required', 'string', 'max:255'],
            'slug'                => ['nullable', 'string', 'max:255', Rule::unique('documents', 'slug')->ignore($this->route('document')) ],
            'meta_title'          => ['nullable', 'string'],
            'meta_description'    => ['nullable', 'string'],
            'description'         => ['nullable', 'string'],
            'document_type_id'    => ['nullable', 'exists:document_types,id'],
            'brand_id'            => ['nullable', 'exists:brands,id'],
            'application_id'      => ['nullable', 'exists:applications,id'],
            'solution_id'         => ['nullable', 'exists:solutions,id'],
            'product_category_id' => ['nullable', 'exists:product_categories,id'],
            'location_id'         => ['nullable', 'exists:locations,id'],
            'file'                => ['nullable', 'file', 'max:51200'],
            'thumbnail'           => ['nullable', 'image', 'max:2048'],
            'is_published'        => ['boolean'],
        ];
    }
}
