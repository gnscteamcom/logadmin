<?php


namespace App\Constants;


class AdminStatusConstant
{
    const ADMIN_STATUS_DELETE = 0;  // 删除
    const ADMIN_STATUS_UNABLE = 1;  // 禁用
    const ADMIN_STATUS_ABLE   = 2;  // 可用

    static public $admin_status = array(
        self::ADMIN_STATUS_UNABLE,
        self::ADMIN_STATUS_ABLE
    );


    const ADMIN_STATUS_LIST  = [
        self::ADMIN_STATUS_DELETE   =>   '删除',
        self::ADMIN_STATUS_UNABLE   =>   '禁用',
        self::ADMIN_STATUS_ABLE     =>   '在用',
    ];



    const USER_ROLE_SUPER  = 1; // 超级管理员
    const USER_ROLE_OBSERVER = 2; // 普通观察者
}
