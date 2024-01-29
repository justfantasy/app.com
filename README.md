#### PHP代码规范
代码规范使用PSR12标准，可下载IDE插件。参考链接：https://www.php-fig.org/psr/psr-12/
#### MYSQL数据库规范
1. 数据库表名字 必须 为「复数」，多个单词情况下使用「Snake Case」 如：photos, my_photos。
2. 数据库字段名 必须 为「Snake Case」，如：age，view_count，is_vip。
3. 数据库表主键 必须 为「id」，主键自增。
4. 数据库表外键 必须 为「resource_id」，如：user_id, post_id, my_photo_id。
5. 常用查询条件和排序建立索引，考虑最左前缀原则。非必要不建立唯一索引，由程序控制唯一性。
6. 使用yii migrate完成数据库修改的版本控制和迁移，写入上线脚本。
#### YII框架开发规范
1. 通过GII生成模型、控制器、模块
2. 控制器
   - 精炼，包含的操作（方法）代码简短。
   - 访问请求数据
   - 调用模型方法、trait、事件、队列任务
3. 模型
   - 包括属性、验证规则、数据库操作逻辑。
   - 不直接访问请求、session等环境数据
   - 业务逻辑请使用trait或自定义组件component
4. 视图，（略）前后端分离尽量不用视图。前后端分离如何保证前后端常量的一致性？
5. 模块，大型项目根据项目特性分成不同的模块。
6. 路由，项目开发中统一使用 URL助手类：yii\helpers\Url::to(['site/index']); 生成链接
7. 数据库查询
   - 只查询需要的字段
   - one()和scalar()查询，若无法保证只有一行，需带上limit(1)限制，如果有多行yii2会从数据库查询多行再拿第一条
   - AR查询多条数据，使用asArray()方法可以提升查询效率
   - 处理大数据时，使用批处理查询
```php
use yii\db\Query;

$query = (new Query())
->from('user')
->orderBy('id');

foreach ($query->batch() as $users) {
    // $users 是一个包含100条或小于100条用户表数据的数组
}

// or to iterate the row one by one
foreach ($query->each() as $user) {
   // 数据从服务端中以 100 个为一组批量获取，
   // 但是 $user 代表 user 表里的一行数据
}
```
8. 使用yii2自带的用户认证功能实现用户登录注册。
9. 不常更新数据进行缓存。yii2自带缓存方式：
```php 
// 尝试从缓存中取回 $data
$data = $cache->get($key);

if ($data === false) {

    // $data 在缓存中没有找到，则重新计算它的值

    // 将 $data 存放到缓存供下次使用
    $cache->set($key, $data);
}

// 这儿 $data 可以使用了。

// 或者
$data = $cache->getOrSet($key, function () {
   return $this->calculateSomething();
});
```
10. 用户端使用redis作为缓存组件和session存储组件
11. 优化composer自动加载，安装扩展后执行。
```shell
 composer dumpautoload -o
```
12. 使用调试工具栏查看SQL语句，对代码进行优化
13. 使用yii2自带行为注入插入和更新的时间戳：字段名可修改，默认为created_at、updated_at
```php 
namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

class Article extends \yii\db\ActiveRecord {

   // 需去掉在rules内对created_at和updated_at字段required的限制。  
   public function behaviors(){
      return [
         ['class' => TimestampBehavior::className()]
      ];
   }    
}
```
#### YII2常用扩展
1. yiisoft/yii2-queue：队列解决方案
2. intervention/image：图像处理解决方案（文档详细，star较多）。备用：yiisoft/yii2-imagine
3. guzzlehttp/guzzle：curl请求解决方案（文档详细，star较多）。备用：yiisoft/yii2-httpclient
4. yiisoft/yii2-redis：redis解决方案
5. overtrue/wechat：微信相关SDK解决方案
#### 目录结构
```
// 英文注释为yii2框架自带目录，中文注释为新加目录
common
   config/              contains shared configurations
   mail/                contains view files for e-mails
   models/              contains model classes used in both backend and frontend
   tests/               contains tests for common classes
   extensions/          用于存放对于yii2和第三方包的扩展类
   exceptions/          自定义异常目录，非系统自带异常请在此处定义，书写好注释
   components/          组件目录，自定义组件保存位置，例如：WechatComponent.php，注意：组件需在config目录的main.php文件中进行注册  
   constants/           常量目录，通用的保存到Constant.php，分特性增加文件：CacheConstant.php
      Constant.php
   helpers/             助手目录，通用的保存到Helper.php，分特性增加文件：UrlHelper.php
      Helper.php
   traits/              traits目录，用于业务逻辑的复用，分功能增加文件：DemoTrait.php
   jobs/                队列任务目录，用于异步的队列任务，分功能增加文件：DemoJob.php
   events/              事件类目录，用于记录触发的事件类，分功能增加文件：DemoEvent.php
console
   config/              contains console configurations
   controllers/         contains console controllers (commands)
   migrations/          contains database migrations
   models/              contains console-specific model classes
   runtime/             contains files generated during runtime
backend                  
   assets/              contains application assets such as JavaScript and CSS
   config/              contains backend configurations
   controllers/         contains Web controller classes
      Controller.php    后台控制器基类，后台控制器请继承该基类
   models/              contains backend-specific model classes
   runtime/             contains files generated during runtime
   tests/               contains tests for backend application    
   views/               contains view files for the Web application
   web/                 contains the entry script and Web resources
frontend                 
   assets/              contains application assets such as JavaScript and CSS
   config/              contains frontend configurations
   controllers/         contains Web controller classes
      Controller.php    前台控制器基类，前台控制器请继承该基类
   models/              contains frontend-specific model classes
   runtime/             contains files generated during runtime
   tests/               contains tests for frontend application
   views/               contains view files for the Web application
   web/                 contains the entry script and Web resources
   widgets/             contains frontend widgets
api                     接口，用于其它项目curl方式调用，密钥认证+IP认证
   assets/              contains application assets such as JavaScript and CSS
   config/              contains frontend configurations
   controllers/         contains Web controller classes
      Controller.php    接口控制器基类，接口控制器请继承该基类
   models/              contains frontend-specific model classes
   runtime/             contains files generated during runtime
   tests/               contains tests for frontend application
   views/               contains view files for the Web application
   web/                 contains the entry script and Web resources
   widgets/             contains frontend widgets
   vendor/              contains dependent 3rd-party packages
   environments/        contains environment-based overrides
vue-frontend/           vue前台前端代码，建议使用vant vue3组件库
   dist/                打包目录，由开发完成打包测试上线
vue-backend/            vue后台前端代码，建议使用pearadmin vue3组件库
   dist/                打包目录，由开发完成打包测试上线  
```
#### 响应状态码
``` 
// 系统自带状态码
yii\web\BadRequestHttpException：状态码 400。            // 错误的请求
yii\web\UnauthorizedHttpException：状态码 401。          // 未授权的请求
yii\web\ForbiddenHttpException：状态码 403。             // 被禁止的请求
yii\web\NotFoundHttpException：状态码 404。              // 找不到页面
yii\web\MethodNotAllowedHttpException：状态码 405。      // 请求方法被禁止
yii\web\NotAcceptableHttpException：状态码 406。         // 无法完成的请求
yii\web\ConflictHttpException：状态码 409。              // 冲突的请求
yii\web\GoneHttpException：状态码 410。                  // 资源不存在
yii\web\TooManyRequestsHttpException：状态码 429。       // 请求太频繁
yii\web\UnsupportedMediaTypeHttpException：状态码 415。  // 不支持的媒体类型

yii\web\ServerErrorHttpException：状态码 500。           // 服务端出错了

// 如需自定义抛出异常，请在common/exceptions目录下定义相关异常并书写好注释
```
#### 错误日志的记录
1. 在企业微信中新建一个异常通知群，增加一个通知机器人
2. 代码中新增企业微信通知log target类型
3. 将服务器错误和主动捕获的异常或日志通过机器人发送到企业微信异常通知群
4. 主动捕获极端异常并发送到企业微信通知群

####  RESTful API开发规范
1. 继承基类yii\rest\Controller
2. 默认操作方法，其它方法语义化定义
   + index 列表
   + view 详情
   + create 创建
   + update 更新
   + delete 删除
3. 必传参数类似id，通过方法的参数接收（建议）
```
// v1/jwt/login?id=1
public function actionData($id)
{
  echo $id;
  return $this->asJson(['success' => true]);
} 
```
4. 返回值包裹为3个字段
   + code: 0为正常，< 0 表示错误
   + data: 后端返回的数据内容
   + msg: 提示文本
```json
{
   "code": 0,   
   "data": [],
   "msg": ""
}
```
```php
# 请使用通用返回方法
common\Helper::response($data, $code, $msg);
```