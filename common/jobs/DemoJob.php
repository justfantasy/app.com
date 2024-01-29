<?php
/**
 * demo队列任务
 */
namespace common\jobs;

use yii\base\BaseObject;
use yii\queue\JobInterface;

class DemoJob extends BaseObject implements JobInterface
{
    public $id;

    /**
     * 使用方式： Yii::$app->queue->push(new DemoJob(['id' => 'demo']));
     */
    public function execute($queue)
    {
        echo $this->id;
    }
}

