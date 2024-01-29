<?php
/**
 * 微信相关组件类
 */

namespace common\components;

use Yii;
use EasyWeChat\Factory;
use yii\base\Component;
use EasyWeChat\OfficialAccount\Application;

/**
 * 参考文档：https://github.com/jianyan74/yii2-easy-wechat
 * 根据我们项目的实际情况，去掉了一些不需要的东西，增加了移动应用配置
 * 加入以下注释，才能追踪魔术方法生成的变量
 * 去掉了__get魔术方法，因为yii2 baseObject已经实现了该功能
 *
 * @property Application $app 微信SDK实例（移动应用）
 * @property Application $web 微信SDK实例（网站应用）
 * @property \EasyWeChat\Payment\Application $payment 微信支付SDK实例
 * @property \EasyWeChat\MiniProgram\Application $miniProgram 微信小程序实例
 * @property \EasyWeChat\Work\Application $work 企业微信实例
 */
class WechatComponent extends Component
{
    // 服务号实例
    private static $app = null;

    // 商户号实例
    private static $payment = null;

    // 小程序实例
    private static $miniProgram = null;

    // 企业微信实例
    private static $work = null;

    public function getApp(): Application
    {
        if (!self::$app) {
            self::$app = Factory::officialAccount(Yii::$app->params['wechatConfig']);
        }

        return self::$app;
    }

    public function getPayment(): ?\EasyWeChat\Payment\Application
    {
        if (!self::$payment) {
            self::$payment = Factory::payment(Yii::$app->params['wechatPaymentConfig']);
        }

        return self::$payment;
    }

    public function getMiniProgram(): ?\EasyWeChat\MiniProgram\Application
    {
        if (!self::$miniProgram) {
            self::$miniProgram = Factory::miniProgram(Yii::$app->params['wechatMiniProgramConfig']);
        }

        return self::$miniProgram;
    }

    public function getWork(): ?\EasyWeChat\Work\Application
    {
        if (!self::$work) {
            self::$work = Factory::work(Yii::$app->params['wechatWorkConfig']);
        }

        return self::$work;
    }
}
