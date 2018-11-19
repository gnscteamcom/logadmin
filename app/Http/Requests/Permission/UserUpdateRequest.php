<?php

namespace App\Http\Requests\Permission;

use App\Constants\LanguageConstant;
use App\Http\Requests\ApiRequest;
use App\Rules\EachArrayExistsOrEmpty;
use App\Rules\ZeroOrExists;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /*
         * todo 较验是本人或管理可以更新
         */
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'       => 'required|numeric|exists:users,id',
            'username' => 'nullable|unique:users,username',
            'email'    => 'nullable|unique:users,email|email',
            'tel'      => 'nullable',
            'status'   => 'nullable|numeric',
            'lang'     => [
                'nullable',
                Rule::in(LanguageConstant::$lang_conf)
            ],
            'password' => 'nullable|min:6',
            'role_ids' => [
                'nullable',
                new EachArrayExistsOrEmpty('roles', 'id')
            ],
            'rebind'   => 'nullable|in:0,1',  //当rebind为1时,将会先清空用户当前的所有角色，再为该用户添加role_ids数组中的角色
            'group_id' => [
                'nullable',
                new ZeroOrExists('groups', 'id')
            ],
        ];
    }
}
