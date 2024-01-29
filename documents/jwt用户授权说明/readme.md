### 后端Yii2框架设置
1. 进入对应子项目的配置文件目录。
+ 修改用户认证组件
+ 修改响应格式为json
+ 增加jwt认证组件，设置认证密钥key
+ 增加jwt验证行为
```php
# 此处以backend子项目为例，用户表为admin_user，model类名为common\models\AdminUser
# backend/config/main.php
# identityClass为验证用户的model类
[
    'components' => [
        // 修改用户认证组件common\models\User为用户表对应的model类
        'user' => [
            'identityClass' => 'common\models\AdminUser', 
        ],
        // 修改响应为格式为json
        'response' => [
            'format' => 'json', 
        ],
        // 增加jwt认证组件，设置认证密钥key
        'jwt' => [
            'class' => sizeg\jwt\Jwt::class,
            'key'   => 'secret key',
        ],
    ],
    // 增加jwt验证行为
    'as authenticator' => [
        'class' => sizeg\jwt\JwtHttpBearerAuth::class,
        'optional' => [ // 排除不需要验证的路由
            'v1/jwt/login',
        ]
    ]
];
```

2. 修改用户表model类，需要实现IdentityInterface认证接口，认证类需实现5个方法
> 参考文档：https://www.yiiframework.com/doc/guide/2.0/zh-cn/security-authentication
```php
class AdminUser extends ActiveRecord implements IdentityInterface
{
    # 重点！！通过Jwt里面拿到的uid，获取用户信息，此处uid为设置jwt时自定义的参数名，可更换
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['id' => intval($token->getClaim('uid'))]);
    }
    
    # 获取该认证实例表示的用户的ID
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    
    # jwt用不到，留空即可
    public static function findIdentity($id)
    {
        
    }

    # jwt用不到，留空即可
    public function getAuthKey()
    {
        
    }
    
    # jwt用不到，留空即可
    public function validateAuthKey($authKey)
    {
        
    }
}
```
3. jwt认证完成，通过user组件获取用户认证信息
```php
# 当前用户的身份实例。未认证用户则为 Null 。
$identity = Yii::$app->user->identity;

# 当前用户的ID。 未认证用户则为 Null 。
$id = Yii::$app->user->id;
```

4. 用户登录完成，生成Jwt返回给前端
```php
// 生成 Token 方法
$jwt = Yii::$app->jwt;
$signer = $jwt->getSigner('HS256');
$key = $jwt->getKey();
$time = time();
$token = $jwt->getBuilder()
    ->issuedAt($time)          # jwt开始生效的时间，多服务器时间不一致会导致jwt无效
    ->expiresAt($time + 3600)  # jwt有效期，此处需跟前端约定有效期，做好失效处理
    ->withClaim('uid', 10)     # 此处10为登录用户id，此处的uid对应model类中获取的jwt参数，可自定义，保持一致即可
    ->getToken($signer, $key); # 生成token
return ['token'=>(string)$token];
```

### 前端jwt参数传递方式
1. Authorization = Bearer+空格+token
2. header头参数名：Authorization
3. header头参数值：Bearer + ' ' + [token] 
4. 说明：Bearer为约定字符串，Bearer后界需要加一个空格，然后再加上后端返回的token
5. 示例:
```js
xhr.setRequestHeader("Authorization", "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MzU4MzU3NDEsImV4cCI6MTYzNTgzOTM0MSwidWlkIjoxMCwibmFtZSI6ImxpbWoifQ.os_zgow9XUOUMhS64kyxRSKGgFKa0xB9V8suCyChiEs"); 
```
