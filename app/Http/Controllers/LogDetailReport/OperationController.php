<?php

namespace App\Http\Controllers\LogDetailReport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\LogDetailReport\OperationRepository;
use App\Constants\LogDetailReport\OperationConstant;
use App\Format\LogDetailReport\OperationFormat;



class OperationController extends Controller
{
	public function __construct(Request $request,
                                OperationConstant $operationConstant,
                                OperationFormat $operationFormat,
                                 OperationRepository $operationRepository)
	{
        $this->request = $request;
        $this->operationRepository = $operationRepository;
        $this->operationConstant = $operationConstant;
        $this->operationFormat = $operationFormat;
	}



	/**
	 *  日志列表详情页面
	 */
	public function dataList()
	{
	    $operateStartDate = $this->request->get('operate_start_date') ?? date('Y-m-d');
        $operateEndDate = $this->request->get('operate_end_date') ?? date('Y-m-d');
        $operateStartTime = $this->request->get('operate_start_time') ?? '00:00:00';
        $operateEndTime = $this->request->get('operate_end_time') ?? '23:59:59';
        $logType = $this->request->get('log_type') ?? '-1';
        $logLevel = $this->request->get('log_level') ?? '-1';
        $sourceName = $this->request->get('source_name') ?? '';
        $buName = $this->request->get('bu_name') ?? '';
        $sourceIp = $this->request->get('source_ip') ?? '';
        $contents = $this->request->get('contents') ?? '';

        $where = array();
        $startTimestamp = strtotime($operateStartDate.''.$operateStartTime);
        $endTimestamp = strtotime($operateEndDate.''.$operateEndTime);
        $where[] = ["addtime",'>=',(int)$startTimestamp];
        $where[] = ["addtime","<=",(int)$endTimestamp];
        if(!empty($logType) && $logType != -1){
            $where[] = ['type','=',(int)$logType];
        }

        if(!empty($logLevel) && $logLevel != -1){
            $where[] = ['level','=',(int)$logLevel];
        }

        if($buName != ''){
            $where[] = ["bu",'like',"%$buName%"];
        }

        if($sourceName != ''){
            $where[] = ["source",'like',"%$sourceName%"];
        }

        if($sourceIp != ''){
            $where[] = ["ip",'like',"%$sourceIp%"];
        }

        if($contents != ''){
            $where[] = ["contents",'like',"%$contents%"];
        }

        $startMonth = date('m',strtotime($operateStartDate));
        $endMonth = date('m',strtotime($operateEndDate));
        if($startMonth != $endMonth)//跨月
        {
            $dateSuffix = date('Y',strtotime($operateStartDate));
        }
        else
        {
            $dateSuffix = date('Ym',strtotime($operateStartDate));
        }

        $dataObj = $this->operationRepository->getOperationLogData($dateSuffix,$where);
        $logList = $this->operationFormat->formatOperationLogData($dataObj);



        $param['list'] = $logList;
        $param['totalCount'] = $dataObj->total();
        $param['operate_start_date'] = $operateStartDate;
        $param['operate_end_date'] = $operateEndDate;
        $param['operate_start_time'] = $operateStartTime;
        $param['operate_end_time'] = $operateEndTime;
        $param['log_type_list'] = $this->operationConstant::LOG_TYPE_LIST;
        $param['log_type'] = $logType;
        $param['log_level_list'] = $this->operationConstant::LOG_LEVEL_LIST;
        $param['log_level'] = $logLevel;
        $param['source_name'] = $sourceName;
        $param['bu_name'] = $buName;
        $param['source_ip'] = $sourceIp;
        $param['contents'] = $contents;

        return view('backend.operation.list',$param);
	}
}
