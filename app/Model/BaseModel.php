<?php

namespace App\Model;


use App\Helpers\BaseHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    private $helper;
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->helper = new BaseHelper();
    }
}
