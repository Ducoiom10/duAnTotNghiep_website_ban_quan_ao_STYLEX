<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            
            'name' => ['required', 'string', 'min:2'],
            'email' => ['required', 'string','email', 'max:200', 'unique:users'],
            'phone_number' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'confirmed', 'min:6'],
        ];
    }
   // Thông báo lỗi tiếng Việt chỉ áp dụng cho request này
    public function messages(): array
    {
        return [
            'name.required'         => 'Họ và tên không được để trống.',
            'name.min'              => 'Họ và tên phải có ít nhất :min ký tự.',
            'email.required'        => 'Email không được để trống.',
            'email.email'           => 'Email không hợp lệ.',
            'email.unique'          => 'Email đã tồn tại trong hệ thống.',
            'phone_number.required' => 'Số điện thoại không được để trống.',
            'phone_number.numeric'  => 'Số điện thoại phải là số.',
            'phone_number.min'      => 'Số điện thoại phải có ít nhất :min chữ số.',
            'password.required'     => 'Mật khẩu không được để trống.',
            'password.min'          => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed'    => 'Xác nhận mật khẩu không khớp.',
        ];
    }

    // Gán tên hiển thị cho các field
    public function attributes(): array
    {
        return [
            'name'         => 'Họ và tên',
            'email'        => 'Email',
            'phone_number' => 'Số điện thoại',
            'password'     => 'Mật khẩu',
        ];
    }
}