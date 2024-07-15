<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'email' => 'required|string|email|unique:users,email, ' . $this->id . '|max:191',
            'name' => 'required|string',
            'user_catalogue_id' => 'required|integer|gt:0'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Bạn chưa nhập vào email.',
            'email.string' => 'Email phải là chuỗi ký tự.',
            'email.email' => 'Email chưa đúng định dạng. Ví dụ: abcd@gmail.com',
            'email.unique' => 'Email đã tồn tại. Hãy chọn email khác.',
            'email.max' => 'Email không được dài quá 191 ký tự.',

            'name.required' => 'Bạn chưa nhập vào tên.',
            'name.string' => 'Tên phải là chuỗi ký tự.',

            'user_catalogue_id.required' => 'Bạn chưa chọn nhóm thành viên dùng.',
            'user_catalogue_id.gt' => 'Bạn chưa chọn nhóm thành viên dùng.',
        ];
    }
}
