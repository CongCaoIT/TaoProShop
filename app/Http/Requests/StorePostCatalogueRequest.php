<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostCatalogueRequest extends FormRequest
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
            'name' => 'required|string',
            'canonical' => 'required|unique:post_catalogue_language',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập vào ô tiêu đề.',
            'name.string' => 'Ô tiêu đề phải là chuỗi ký tự.',
            'canonical.required' => 'Đường dẫn không được để trống.',
            'canonical.unique' => 'Đường dẫn đã tồn tại. Hãy chọn đường dẫn khác.',
        ];
    }
}
