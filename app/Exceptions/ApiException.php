<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    public $status_code = 500;
    public $http_code   = 500;

    private $exception;

    public function __construct($message, $status_code = 500, $http_code = 500, Exception $exception = null)
    {
        parent::__construct($message);

        $this->http_code = $http_code;

        $this->status_code = $status_code;

        $this->exception = $exception;
    }

    public function status($status)
    {
        $this->status = $status;

        return $this;
    }

    public function httpCode($http_code)
    {
        $this->http_code = $http_code;

        return $this;
    }

    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    public function response($message, $status_code = 500, $http_code = 500)
    {

        $this->http_code = $http_code;

        $this->status_code = $status_code;

        $this->message = $message;

        return $this;
    }


    public function getResponse()
    {

        $response = [
            'code' => $this->status_code,
            'msg'  => $this->getMessage(),
        ];

        if (env('APP_DEBUG')) {
            if($this->exception instanceof Exception) {
                $response['trace']['parent_exception'] = $this->exception->getMessage();
                $response['trace']['string'] = $this->exception->getTraceAsString();
            } else {
                $response['trace']['string'] = $this->getTraceAsString();
            }
        }

        return response()->json($response, $this->http_code);
    }
}
