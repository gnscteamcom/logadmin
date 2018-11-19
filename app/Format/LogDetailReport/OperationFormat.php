<?php
namespace App\Format\LogDetailReport;

use App\Services\ToolService;
use App\Constants\LogDetailReport\OperationConstant;


class OperationFormat
{
    public function __construct(OperationConstant $operationConstant)
    {
        $this->operationConstant = $operationConstant;
    }


    public function formatOperationLogData($dataObj)
    {
        $formatArray = array();
        foreach($dataObj as $data){
            $temp = array();
            $temp['id'] = $data['id'] ?? '';
            $temp['source'] = $data['source'] ?? '';
            $temp['bu'] = $data['bu'] ?? '';
            $temp['contents'] = $data['contents'] ?? '';
            $temp['ip'] = $data['ip'] ?? '';
            $temp['addtime'] = date('Y-m-d H:m:s',$data['addtime']) ?? '';
            $temp['type'] = $this->operationConstant::LOG_TYPE_LIST[$data['type']] ?? '';
            $temp['level'] = $this->operationConstant::LOG_LEVEL_LIST[$data['level']] ?? '';
            $temp['contents_short'] = mb_substr($data['contents'],0,10,'utf-8');
            $formatArray[] = $temp;
            unset($temp);
        }

        return $formatArray;
    }
}
