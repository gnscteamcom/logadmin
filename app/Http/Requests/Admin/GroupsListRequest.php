<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiRequest;
use App\Rules\EachArrayExistsOrEmpty;

class GroupsListRequest extends ApiRequest
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
            'role_ids' => [
                'nullable',
                new EachArrayExistsOrEmpty('roles', 'id')
            ],
        ];
    }
}
