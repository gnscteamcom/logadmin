<?php

namespace App\Exceptions;
use App\Constants\ResponseConstant;

class ApiStatusException extends ApiException
{
    public function __construct($status_code = 500, array $i18n_mapping = ResponseConstant::I18N_MAPPING, $http_code = 500)
    {
        parent::__construct($this->getMessageByStatusAndMapping($i18n_mapping, $status_code));
        $this->http_code = $http_code;
        $this->status_code = $status_code;
    }

    private function getMessageByStatusAndMapping(array $i18n_mapping, $status_code)
    {
        if(empty($i18n_mapping) || empty($status_code)) {
            return trans('response.base_undefined_response_message');
        }

        if(isset($i18n_mapping[$status_code])) {
            return trans($i18n_mapping[$status_code]);
        }

        return trans('response.base_undefined_i18n_key');
    }
}
