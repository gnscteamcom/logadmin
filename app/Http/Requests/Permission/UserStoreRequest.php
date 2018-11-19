<?php

namespace App\Http\Requests\Permission;

use App\Constants\LanguageConstant;
use App\Http\Requests\ApiRequest;
use App\Rules\EachArrayExistsOrEmpty;
use App\Rules\ZeroOrExists;
use Illuminate\Validation\Rule;

class UserStoreRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'username' => 'required|unique:users,username',
            'email'    => 'required|unique:users,email|email',
            'tel'      => 'nullable',
            'lang'     => [
                'nullable',
                Rule::in(LanguageConstant::$lang_conf)
            ],
            'password' => 'required|min:6',
            'status'   => 'nullable|numeric',
            'role_ids' => [
                'nullable',
                new EachArrayExistsOrEmpty('roles', 'id')
            ],
            'group_id' => [
                'nullable',
                new ZeroOrExists('groups', 'id')
            ]
        ];
    }
}
