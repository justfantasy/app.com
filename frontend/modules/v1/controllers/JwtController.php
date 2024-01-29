<?php

/**
 * JwtController
 * 作者: laoren
 * 版本: 2021/10/28
 */

namespace frontend\modules\v1\controllers;

use sizeg\jwt\Jwt;
use Yii;
use yii\base\Exception;
use yii\base\UserException;
use yii\web\HttpException;
use yii\web\UnauthorizedHttpException;

class JwtController extends BaseController
{
    /**
     * @return \yii\web\Response
     */
    public function actionLogin($id)
    {
        /** @var Jwt $jwt */
        $jwt = Yii::$app->jwt;
        $signer = $jwt->getSigner('HS256');
        $key = $jwt->getKey();
        $time = time();
        $token = $jwt->getBuilder()
            ->issuedAt($time)// Configures the time that the token was issue (iat claim)
            ->expiresAt($time + 3600)// Configures the expiration time of the token (exp claim)
            ->withClaim('uid', 1)// Configures a new claim, called "uid"
            ->getToken($signer, $key); // Retrieves the generated token
        return $this->asJson(['token' => (string)$token]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionData($id)
    {
        echo $id;
        return $this->asJson(['success' => true]);
    }
}