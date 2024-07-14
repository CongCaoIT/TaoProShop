<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => 'required|string|email|unique:users|max:191',
            'name' => 'required|string',
            'user_catalogue_id' => 'required|integer|gt:0',
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/[a-z]/',      // Phải có ít nhất một chữ cái thường
                'regex:/[A-Z]/',      // Phải có ít nhất một chữ cái viết hoa
                'regex:/[0-9]/',      // Phải có ít nhất một chữ số
                'regex:/[@$!%*#?&]/', // Phải có ít nhất một ký tự đặc biệt
            ],
            're_password' => 'required|string|same:password',
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

            'password.required' => 'Bạn chưa nhập vào mật khẩu.',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.regex' => 'Mật khẩu phải có ít nhất một chữ cái thường, một chữ cái viết hoa, một chữ số và một ký tự đặc biệt.',

            're_password.required' => 'Bạn chưa nhập lại mật khẩu.',
            're_password.string' => 'Mật khẩu nhập lại phải là chuỗi ký tự.',
            're_password.same' => 'Mật khẩu nhập lại không khớp.',
        ];
    }
}
