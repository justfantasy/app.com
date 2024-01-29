一、服务端Yii2框架配置

+ 第一步：在项目的main.php文件中配置，如下

```php
[
    'components' => [
        'response' => [
            'format' => 'json', // 如果使用rest风格，这个地方要配置，否则抛出异常会报错。
        ],
    ],
    'as sign' => [
        'class' => common\behaviors\DemoBehavior::class,
        'signSecret' => "aaaaa", // 加密串
        'whiteIpList'=>['192.168.119.1'],// 配置ip白名单
        'expireTime' => 300, // 配置过期时间
    ],
];
```

+ 第二步：在新建的控制器中写业务逻辑代码，校验验证在上面的配置的行为中已完成


二、客户端请求方法

+ 默认支持GET,POST 请求，如需支持其他方式请求，可以联系服务端配置其他
+ 请求中必要的参数有timestamp(当前时间戳)，sign(加密的字符串)
+ 加密规则如下：
    
    1.所有参数名按照ASCII顺序从小到大排序，然后拼接字符串。例如age=10&name=li&timestamp=1636008287；注意:参数sign不参与排序
    
    2.把“步骤一”拼接好的字符串再次拼接【&sign=(服务端加密串)】进行md5加密，然后再全部转小写字母的得出sign的值
    
    3.最后请求服务端带上参数sign值
