<?php

namespace App\Constants;


class LanguageConstant
{
    const LANG_ZH = 'zh-CN';      // 中文简体
    const LANG_EN = 'en-US';      // 英语

    public static $lang_conf = array(
        'zh' => self::LANG_ZH,
        'en' => self::LANG_EN,
    );

    //根据用户语言类型映射所选语言默认时区
    const TIME_ZONE_CONFIG = [
        self::LANG_EN => 'America/New_York',
        self::LANG_ZH => 'Asia/Shanghai',
    ];

    //default time zone
    const DEFAULT_TIME_ZONE = 'Asia/Shanghai';
}
