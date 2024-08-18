<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
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
            'canonical' => 'required|unique:permissions,canonical, ' . $this->id . ''
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập vào tên quyền.',
            'name.string' => 'Tên quyền phải là chuỗi ký tự.',

            'canonical.required' => 'Bạn chưa nhập từ khóa.',
            'canonical.unique' => 'Từ khóa đã bị trùng. Vui lòng chọn từ khóa khác.',
        ];
    }
}
