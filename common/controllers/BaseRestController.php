<?php

namespace common\controllers;

use common\models\Model;
use yii\base\InvalidConfigException;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

abstract class BaseRestController extends Controller
{
    /**
     * 可选，若想使用findModel方法
     * @var Model|null
     */
    public $model = null;

    /**
     * 限制method
     * @return array[]
     */
    protected function verbs(): array
    {
        return [
            'delete' => ['DELETE'],
            'index' => ['GET'],
            'view' => ['GET'],
            'create' => ['POST'],
            'update' => ['PUT'],
        ];
    }

    /**
     * 通过唯一ID获取模型
     * @param $id
     * @return Model|null
     * @throws NotFoundHttpException|InvalidConfigException
     */
    public function findModel($id): ?Model
    {
        if ($this->model === null) {
            throw new InvalidConfigException(get_class($this) . '::$model must be set.');
        }

        if (($model = $this->modelClass::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('页面不存在！');
    }
}
