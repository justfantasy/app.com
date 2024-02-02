<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Model extends ActiveRecord
{
    /**
     * 重构fields，默认返回查询出来的关联关系表
     */
    public function fields()
    {
        $relatedFields = array_keys($this->getRelatedRecords());

        return array_merge(
            parent::fields(),
            array_combine($relatedFields, $relatedFields)
        );
    }
}
