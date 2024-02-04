<?php

namespace common\models\admin;

use Yii;
use common\models\Model;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "admin_users".
 *
 * @property int $id
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $real_name 姓名
 * @property int $status 状态
 * @property int $created_at
 * @property int $updated_at
 */
class AdminUser extends Model implements IdentityInterface
{
    /**
     * 禁用状态
     */
    const STATUS_INACTIVE = 1;

    /**
     * 正常状态
     */
    const STATUS_ACTIVE = 0;

    /**
     * 绑定相关行为
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'admin_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['username', 'password', 'real_name'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['username', 'real_name'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 64],
            [['username'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'real_name' => 'Real Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * 重构，去掉敏感字段
     * @return array|false|int[]|string[]
     */
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['password']);
        return $fields;
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findIdentity(intval($token->getClaim('user_id')));
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey(): ?string
    {
        return '';
    }

    public function validateAuthKey($authKey): ?bool
    {
        return true;
    }

    /**
     * 获取用户角色
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getRoles(): ActiveQuery
    {
        return $this->hasMany(AdminRole::class, ['id' => 'role_id'])
            ->viaTable('admin_user_role', ['user_id' => 'id']);
    }
}
