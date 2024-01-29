<?php

namespace common\events;

use yii\base\Component;

class DemoEvent extends Component
{
    public function doSomething($event)
    {
        echo '我在执行一个事件！' . $event->name . '<br>';
        echo '我拿到了数据：' . $event->data . '<br>';
    }
}
