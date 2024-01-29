<?php

/**
 * 助手类方法，不同特性的帮助类需新建对应的帮助类，例如：url. array.等等
 */

namespace common\helpers;

use Yii;

class Helper
{
    // 获取用户真实ip
    public static function getUserRealIp()
    {
        if (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipList = explode(', ', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return $ipList[0];
        }
        return Yii::$app->request->userIP;
    }

    // 自定义写日志
    public static function log($arr, $file = 'log')
    {
        error_log(
            var_export($arr, true),
            3,
            \Yii::$app->basePath . '/runtime/logs/' . $file . '_' . date('Ymd') . '.log'
        );
    }

    /*
     * 格式化返回值
     * code: 0 正确，其它值按约定自定义
     * data: 需要返回的内容
     * msg: 提示信息
     */
    public static function response($data, $code = 0, $msg = '')
    {
        return ['code' => $code, 'data' => $data, 'msg' => $msg];
    }
}
