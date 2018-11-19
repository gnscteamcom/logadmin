<?php

namespace App\Http\Requests\Permission;

use App\Http\Requests\ApiRequest;
use App\Rules\EachArrayExists;

class ResourceBindUserRequest extends ApiRequest
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
            'user_id'      => 'required|numeric|exists:users,id',
            'rebind'       => 'nullable|in:0,1',
            'resource_ids' => [
                'nullable',
                'array',
                new EachArrayExists('resources', 'id')
            ]
        ];
    }
}
