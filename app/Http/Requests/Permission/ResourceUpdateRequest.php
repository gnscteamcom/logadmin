<?php

namespace App\Http\Requests\Permission;

use App\Http\Requests\ApiRequest;
use App\Rules\ResourceAllowMethod;
use App\Rules\UniqueUnionKey;

class ResourceUpdateRequest extends ApiRequest
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
            'id'       => 'required|numeric|exists:resources,id',
            'group_id' => 'required|numeric|exists:resource_groups,id',
        ];
    }
}
