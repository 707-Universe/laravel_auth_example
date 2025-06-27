<?php

namespace App\Http\Requests\V1\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// Todo: パスワードに記号を入れさせるようにする。
class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:30',
            'email' => [
                'required',
                'email',
                'max:190',
                Rule::unique('users')->whereNot('email_verified_at', null),
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:48',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'name' => '氏名',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attributeは必須項目です。',
            'name.max' => ':attributeは:max以内にしてください。',
            'email.required' => ':attributeは必須項目です。',
            'email.email' => ':attributeの形式が正しくありません。',
            'email.max' => ':attributeは:max以内にしてください。',
            'password.required' => ':attributeは必須項目です。',
            'password.min' => ':attributeは:min以上にしてください。',
            'password.max' => ':attributeは:max以内にしてください。',
            'password.regex' => 'パスワードの形式が正しくありません。',
        ];
    }
}
