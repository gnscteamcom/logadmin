<?php
/**
 * Created by PhpStorm.
 * User: WangYe
 * Date: 2018/11/13
 * Time: 15:07
 */

namespace App\Constants\LogDetailReport;


class OperationConstant
{
    const LOG_LEVEL_EMERG   = 1; //emerg内核奔溃等严重报错
    const LOG_LEVEL_ALERT   = 2; //alert需要立即修复的报错
    const LOG_LEVEL_CRIT    = 3; //crit严重级别
    const LOG_LEVEL_ERROR   = 4; //error错误级别
    const LOG_LEVEL_WARING  = 5;//warning警告级别
    const LOG_LEVEL_NOTICE  = 6;//notice级别
    const LOG_LEVEL_INFO    = 7;//info一般信息的日志
    const LOG_LEVEL_DEBUG   = 8;//debug调试信息日志

    const LOG_LEVEL_LIST  = [
        self::LOG_LEVEL_EMERG   =>   'emerg',
        self::LOG_LEVEL_ALERT   =>   'alert',
        self::LOG_LEVEL_CRIT    =>   'crit',
        self::LOG_LEVEL_ERROR   =>   'error',
        self::LOG_LEVEL_WARING  =>   'warning',
        self::LOG_LEVEL_NOTICE  =>   'notice',
        self::LOG_LEVEL_INFO    =>   'info',
        self::LOG_LEVEL_DEBUG   =>   'emerg',
    ];



    const LOG_TYPE_SYSTEM    = 1; //系统服务类日志
    const LOG_TYPE_PROGRAM   = 2; //用户程序类日志
    const LOG_TYPE_SAFE      = 3; //安全权限类日志
    const LOG_TYPE_PRINT     = 4; //打印日志
    const LOG_TYPE_CRON      = 5;//cron任务日志

    const LOG_TYPE_LIST  = [
        self::LOG_TYPE_SYSTEM    =>   '系统服务类日志',
        self::LOG_TYPE_PROGRAM   =>   '用户程序类日志',
        self::LOG_TYPE_SAFE      =>   '安全权限类日志',
        self::LOG_TYPE_PRINT     =>   '打印日志',
        self::LOG_TYPE_CRON      =>   'cron任务日志',
    ];



    const STATUS_UNDISPOSED   = 0; //未处理
    const STATUS_DISPOSED      = 1; //已处理
    const STATUS_DELETE        = 2; //删除或无效

    const STATUS_LIST  = [
        self::STATUS_UNDISPOSED   =>   '未处理',
        self::STATUS_DISPOSED   =>   '已处理',
        self::STATUS_DELETE    =>   '删除或无效',
    ];
}