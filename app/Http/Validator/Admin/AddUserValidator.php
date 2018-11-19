<?php
namespace App\Http\Validator\Admin;


use App\Http\Validator\ApiValidator;

class AddUserValidator implements ApiValidator
{
    public function messages()
    {
        return [
            'name.required'  => '用户名不能为空',
            'phone.required'  => '手机号不能为空',
            'password.required'  => '密码不能为空',
            'email.required'  => '邮箱不能为空',
            'status.required'  => '管理员状态不能为空',
            'rid.required'  => '管理员类型不能为空',
        ];
    }

    public function rules()
    {
        return [
            'name'  => 'required',
            'phone'  => 'required',
            'password'  => 'required',
            'email'  => 'required',
            'status'  => 'required',
            'rid'  => 'required',
        ];
    }
}