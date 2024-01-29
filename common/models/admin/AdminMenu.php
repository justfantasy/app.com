<?php

namespace common\models\admin;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "admin_menus".
 *
 * @property int $id
 * @property int $parent_id 父ID
 * @property int $weight 排序权重
 * @property string $name 菜单名
 * @property string $icon 菜单图标
 * @property string $uri 菜单跳转地址
 * @property int $status 状态0正常1隐藏
 * @property int $created_at
 * @property int $updated_at
 */
class AdminMenu extends ActiveRecord
{
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'admin_menus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['parent_id', 'weight', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'icon', 'uri', 'created_at', 'updated_at'], 'required'],
            [['name', 'icon'], 'string', 'max' => 50],
            [['uri'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'weight' => 'Weight',
            'name' => 'Name',
            'icon' => 'Icon',
            'uri' => 'Uri',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
