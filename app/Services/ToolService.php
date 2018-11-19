<?php
namespace App\Services;


class ToolService
{
    /**
     * stdClass 类转数组
     * @param \stdClass 类 $object
     * @return array
     */
    public static function stdClass2array($object)
    {
        return json_decode(json_encode($object),true);
    }

	
	
    /**
     *  金额格式化
     */
    public static function formatMoney($money)
    {
        return number_format($money, 0, '.', '.');
    }

	
	
    /**
     * 金额25的倍数
     * @param $money
     * @return int
     */
    public static function moneyByCeil25($money)
    {
        return intval(ceil(round($money / 25, 0)) * 25);

    }
}