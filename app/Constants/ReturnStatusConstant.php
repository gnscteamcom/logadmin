<?php

namespace App\Constants;

class ReturnStatusConstant
{
    const STATUS_OK = 200;
    const STATUS_PARAMS = 400;
    const STATUS_UNLOGIN = 401;
    const STATUS_FORBID = 403;

    const STATUS_SERVER_ERROR = 500;
    const STATUS_DB_FAILED = 501;
}