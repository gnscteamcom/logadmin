<?php

namespace App\Services;


use Illuminate\Log\Writer;
use Monolog\Logger;

class LogService
{
    // 所有的LOG都要求在这里注册
    const LOG_ERROR       = 'Log';
    const LOGSTASH_FILE   = 'collect_ina';
    const LOGSTASH_MODULE = 'collect_ina';
    static $app;

    public function __construct(Application $app)
    {
        self::$app = $app;
    }

    private static $loggers = array();

    public static function Log($type = self::LOG_ERROR, $level = 'info')
    {

        if (empty(self::$loggers[$type])) {
            self::$loggers[$type] = new Writer(new Logger($type));
            self::$loggers[$type]->useFiles(config('app')['log_path']. '/' . $type .'.log', $level);
        }

        $log = self::$loggers[$type];
        return $log;
    }

    public static function Logstash($level, $action, $message, $params, $file=self::LOG_ERROR)
    {
        $content = array(
            'level'   => $level,
            'module'  => self::LOGSTASH_MODULE,
            'action'  => $action,
            'message' => $message,
            'scheme'  => $params,
        );

        return self::Log($file)->$level(json_encode($content));
    }
}