<?php

namespace App\Http\Requests\Permission;

use App\Http\Requests\ApiRequest;
use App\Rules\ResourceAllowMethod;
use App\Rules\UniqueUnionKey;

class ResourceStoreRequest extends ApiRequest
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
            'uri'    => 'required|min:1',
            'method' => [
                'required',
                new ResourceAllowMethod(),
                new UniqueUnionKey('resources', 'method', 'uri', $this->get('uri'))
            ],
            'name'   => 'nullable|max:64'
        ];
    }
}
