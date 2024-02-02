<?php

/**
 * 助手类方法，不同特性的帮助类需新建对应的帮助类，例如：url. array.等等
 */

namespace common\helpers;

use yii\helpers\VarDumper;

class Helper
{
    public static function dd($var, $depth = 10, $highlight = false)
    {
        VarDumper::dump($var, $depth, $highlight);
        die();
    }
}
