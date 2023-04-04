<h1 align="center">Better-Laravel</h1>
<p align="center">基于PHP8.1，适用于Laravel框架进行快速开发的工具包</p>

<p align="center"><a href="https://github.com/yesccx/better-laravel"><img alt="For Laravel 5" src="https://img.shields.io/badge/laravel-9.*-green.svg" style="max-width:100%;"></a>
<a href="https://packagist.org/packages/yesccx/better-laravel"><img alt="Latest Stable Version" src="https://img.shields.io/packagist/v/yesccx/better-laravel.svg" style="max-width:100%;"></a>
<a href="https://packagist.org/packages/yesccx/better-laravel"><img alt="Latest Unstable Version" src="https://img.shields.io/packagist/vpre/yesccx/better-laravel.svg" style="max-width:100%;"></a>
<a href="https://packagist.org/packages/yesccx/better-laravel"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/yesccx/better-laravel.svg?maxAge=2592000" style="max-width:100%;"></a>
<a href="https://packagist.org/packages/yesccx/better-laravel"><img alt="License" src="https://img.shields.io/packagist/l/yesccx/better-laravel.svg?maxAge=2592000" style="max-width:100%;"></a></p>

# 目录
- [目录](#目录)
- [安装](#安装)
  - [运行环境](#运行环境)
  - [通过Composer引入依赖包](#通过composer引入依赖包)
  - [初始化安装](#初始化安装)
- [基础功能](#基础功能)
  - [路由](#路由)
    - [模块路由](#模块路由)
  - [命令行](#命令行)
    - [迁移文件转换为DDL语句](#迁移文件转换为ddl语句)
    - [Laravel部署优化](#laravel部署优化)
  - [异常处理](#异常处理)
  - [Traits](#traits)
    - [InstanceMake](#instancemake)
      - [Class::make](#classmake)
      - [Class::resolve](#classresolve)
      - [Class::instance](#classinstance)
    - [InitializeTraits](#initializetraits)
  - [BaseService](#baseservice)
  - [辅助方法](#辅助方法)
    - [dumps](#dumps)
    - [dds](#dds)
    - [explode\_str\_array](#explode_str_array)
- [数据库](#数据库)
  - [分页查询](#分页查询)
    - [普通分页查询](#普通分页查询)
    - [简单分页查询](#简单分页查询)
    - [自定义分页数据](#自定义分页数据)
    - [空分页](#空分页)
  - [Builder查询](#builder查询)
    - [customPaginate](#custompaginate)
    - [customSimplePaginate](#customsimplepaginate)
    - [whereLike](#wherelike)
    - [whenLike](#whenlike)
    - [whereToday](#wheretoday)
    - [whereThisDay](#wherethisday)
    - [whereInDay](#whereinday)
    - [whereThisWeek](#wherethisweek)
    - [whereThisMonth](#wherethismonth)
    - [whereInMonth](#whereinmonth)
    - [whereThisYear](#wherethisyear)
    - [whereInYear](#whereinyear)
    - [whereGtDate](#wheregtdate)
    - [whereGteDate](#wheregtedate)
    - [whereLtDate](#whereltdate)
    - [whereLteDate](#whereltedate)
    - [whereBetweenDate](#wherebetweendate)
    - [非严格格式查询](#非严格格式查询)
- [HTTP](#http)
  - [请求响应(Responser)](#请求响应responser)
    - [responseSuccess](#responsesuccess)
    - [responseError](#responseerror)
    - [responseData](#responsedata)
    - [responseException](#responseexception)
  - [控制器基类](#控制器基类)
    - [接口响应(Response)](#接口响应response)
    - [入参类型转换(TypeTransfrom)](#入参类型转换typetransfrom)
  - [表单验证](#表单验证)
    - [表单验证基类](#表单验证基类)
    - [验证场景](#验证场景)
  - [验证规则](#验证规则)
    - [ArrayIdsRule](#arrayidsrule)
    - [Base64Rule](#base64rule)
    - [IdCardRule](#idcardrule)
    - [LandlinePhoneRule](#landlinephonerule)
    - [PhoneRule](#phonerule)
    - [StringArrayIdsRule](#stringarrayidsrule)
    - [SubManyRequestRule](#submanyrequestrule)
    - [SubRequestRule](#subrequestrule)
- [配置项](#配置项)
  - [date\_format](#date_format)
  - [http.route\_scanning](#httproute_scanning)
- [使用建议](#使用建议)
- [License](#license)


# 安装

## 运行环境

| 运行环境要求           |
| ---------------------- |
| PHP ^8.1.0             |
| Laravel Framework ^9.0 |

## 通过Composer引入依赖包

通过终端进入项目根目录，执行以下命令引入依赖包：

``` shell
> composer require yesccx/better-laravel:1.x
```

## 初始化安装

`Better-Laravel` 支持一系列配置参数，如 `默认时间格式` 等，更多配置项参考[配置项](#配置项)章节，通过以下命令进行初始化安装操作：

``` shell
> php artisan better-laravel:install
```

> 初始化之后会默认引入使用服务提供者 `App\Providers\BetterLaravelProvider`，后续可在该提供者内部做更多的定制化处理。

# 基础功能

## 路由

### 模块路由

通常情况下，我们会将路由定义在 `routes/api.php` 文件内。然而随着项目的不断迭代，定义的路由也会越来越多。为了更好地管理这些路由，我们可以选择将它们按照功能模块拆分，并单独定义在不同的路由文件中。
例如，我们可以将用户相关的路由定义在 `routes/modules/user.php` 文件中，将订单相关的路由定义在 `routes/modules/order.php` 中等。这种做法可以有效减少单个路由文件内的接口数量，以清晰地管理项目的接口。

为了引入这些路由文件，我们可以使用 `Better-Laravel` 包中提供的 `模块路由` 快速注册功能。只需将路由文件定义在 `routes/modules` 目录下，其中的路由都将被自动扫描并注册。通过使用 `Better-Laravel` 提供的快速注册功能，我们可以轻松管理和组织各个模块的路由，使代码更加清晰易懂。

以下是示例参考：

``` php
<?php

// routes/modules/user.php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'user'
], function() {
    // Create user
    Route::get('create', [\App\Http\Controller\UserController::class, 'create']);

    // Get userinfo
    Route::get('info', [\App\Http\Controller\UserController::class, 'info']);
});
```

``` php
<?php

// routes/modules/content.php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'content'
], function() {
    // Get list
    Route::get('list', [\App\Http\Controller\ContentController::class, 'list']);

    // Get info
    Route::get('info', [\App\Http\Controller\ContentController::class, 'info']);
});
```

默认情况下，`Better-Laravel` 仅会扫描 `routes/modules` 目录下的路由文件，并为这些路由指定 `prefix` 为 `api`、`middleware` 为 `api` 的参数。如果需要，可以通过配置 `better-laravel.http.scanning_route` 调整相关参数或定义额外的扫描路径。通过自定义配置，我们可以更灵活地管理和组织不同模块的路由，并且能够快速扩展和适应不同项目的需求。

> 通过这种方式定义的路由，不会影响 `route:cache` 缓存生成。

## 命令行

### 迁移文件转换为DDL语句

`Laravel` 允许我们利用 `迁移文件` 进行表结构调整，但有时候可能不方便直连数据库执行迁移文件，又或者想备份迁移文件所执行的具体 `DDL` 语句，此时可以借助 `migrate:to-sql` 脚本将 `迁移文件` 转换为 `DDL` 语句。

``` shell
> php artisan migrate:to-sql --path=database/migrations/2023_03_15_172792_create_users_table

# --------------------------------------------------
# -- Input: database/migrations/2023_03_15_172792_create_users_table.php / up
# -- Datetime: 2023-04-03 10:18:14
# -- Total: 1
# --------------------------------------------------
# -- Migrate：2023_03_15_172792_create_users_table.php

# create table `users` (`id` bigint unsigned not null auto_increment primary key comment '自增id') default character set utf8mb4 collate 'utf8mb4_unicode_ci';

# ALTER TABLE `users` comment '用户表';
# --------------------------------------------------
```

`path` 选项可接收模糊关键字，如想将 `2023-04-03` 当天创建的迁移文件转换，选项参数指定为 `--path=2023_03_15` 即可：

``` shell
# 处理迁移文件名中含有关键字'2023_03_15'的迁移文件
> php artisan migrate:to-sql --path=2023_03_15


# 处理迁移文件名中含有关键字'user'的迁移文件
> php artisan migrate:to-sql --path=user
```

另外可以通过 `type` 选项调整默认处理的迁移文件逻辑，`type` 选项可接收值 `up` / `down`，分别对应迁移文件中的 `up方法` / `down方法`：

``` shell
> php artisan migrate:to-sql --path=2023_03_15 --type=down
```

默认情况下会将转换后的结果直接输出到终端，我们可以通过 `Linux` 中的输出重定向功能将结果保存至指定文件中。
``` shell
> php artisan migrate:to-sql --path=2023_03_15 >> migrate.sql
```

### Laravel部署优化

当项目部署至生产环境后，为了提升应用的性能，我们可以利用 `Laravel` 中提供的一系列命令进行配置优化，例如 `route:cache`、`config:cache` 等（具体参考 [Laravel部署章节](https://learnku.com/docs/laravel/9.x/deployment/12204#a9f94d)）。`Better-Laravel` 中提供了 `optimize:all` 脚本，可以在生产环境中快速优化整个应用程序，该脚本会执行一系列优化操作，以提高应用程序的性能和响应速度。

``` shell
> php artisan optimize:all --force
```

上述脚本会依次执行：

- `event:cache`
- `view:cache`
- `route:cache`
- `config:cache`
- `composer dump-autoload --optimize`

> 如果项目是运行在 `Docker` 容器内的，可以将脚本定义到入口命令 `CMD` 中执行。这样做的好处在于，每次容器启动时都会自动执行优化脚本。

## 异常处理

在 `Better-Laravel` 中对异常类进行了统一的捕获处理，对异常信息进行脱敏后再以标准的接口响应方式响应异常信息([`Responser`](#请求响应(Responser)))，从而提高了应用的安全性和规范性。

其中捕获的 `Laravel内部异常` 有：

- `NotFoundHttpException`：请求的接口地址不存在异常；
- `MethodNotAllowedHttpException`：请求方法不允许异常；
- `ModelNotFoundException`：通过 `firstOrFail` 查询异常；
- `ValidationException`：表单验证失败异常。

对于 `NotFoundHttpException`、`MethodNotAllowedHttpException` 及 `ModelNotFoundException` 这类异常可以理解为应用 `missing` 异常，因此不会直接暴露异常原因，而是提供了默认的提示文案"内容不存在"。同时，我们还提供了 `better-laravel.exception.missing_summary` 配置来自定义提示文案。 对于 `ValidationException` 异常，为表单验证失败时的异常，我们会将其异常原因指定为验证规则的具体错误信息。

其中捕获的 `Better-Laravel` 内部业务异常有：

- `ApiService`：接口异常或业务异常
- `ServiceService`：服务层异常

对于这些异常，我们会直接返回异常原因，并且可以通过开启 `better-laravel.exception.use_exception_code` 使用 `异常码` 的功能，将`异常码` 作为接口响应体中的 `code` 码。

除此之外的异常都被统称为 `其它未知异常`，因为来源不明确，为了防止意外暴露敏感信息，我们同样的会使用统一的提示文案 "系统错误"，此外我们还提供了 `better-laravel.exception.ignored_summary` 配置来自定义提示文案。在开发阶段，您可以通过开启 DEBUG 模式( `APP_DEBUG=true` ) 或者指定 `better-laravel.exception.ignore_tracks` 为 `false`，来显示 `其它未知异常` 的异常栈详情。

但某些时候我们会自定义业务异常类，如果希望在捕获到这类异常后，将异常原因直接返回给客户端，我们可以通过以下方式进行：

- 方式一：业务异常类实现 `Yesccx\BetterLaravel\Contracts\WithExceptionOptions` 接口，并在 `exceptionOptions` 方法中指定不忽略异常栈详情 `["ignore_tracts" => false]` ；
- 方式二：通过将业务异常类 声明至 `App\Providers\BetterLaravelProvider` 中的 `immediateExceptions` 方法内，该方法中声明的异常将不会忽略异常栈信息。

如果您需要禁用这些异常处理逻辑或深度定制化异常处理逻辑，您可以选择在 `App\Providers\BetterLaravelProvider` 中移除这一部分处理逻辑。

> 默认情况下会自动记录异常原因至日志文件中。

## Traits

### InstanceMake

为类引入 `Yesccx\BetterLaravel\Traits\InstanceMake` Trait后，赋于类快速实例化的能力。`InstanceMake` 中包含三种实例化类的方式。

#### Class::make

非单例/支持构建函数传参/不支持构造函数依赖注入:

``` php
class UserService {
    use InstanceMake;

    public function __construct(
        public int $id = 0
    ) {}
};

UserService::make(['id' => 1]);
```

#### Class::resolve

非单例/不支持构建函数传参/支持构造函数依赖注入:

``` php
class UserService {
    use InstanceMake;

    public function __construct(
        public UserModel $model
    ) {}
};

$user = UserService::resolve();
$user->model->find(['id' => 1]);
```

#### Class::instance

单例/不支持构建函数传参/支持构造函数依赖注入:

``` php
class UserService {
    use InstanceMake;

    public function __construct(
        public UserModel $model
    ) {}
};

$user = UserService::resolve();
$user->model->find(['id' => 1]);

// 再次调用时不会重复实例化类
UserService::resolve();

// 指定强制重新实例化类
UserService::resolve(force: true);

```

### InitializeTraits

在 `PHP` 中，我们可以使用 `Trait` 来扩展类的功能。然而，与类不同的是，`Trait` 没有类似构造函数的初始化方法，这使得在使用 `Trait` 时可能会面临一些困难。为了解决这个问题，我们可以利用 `Yesccx\BetterLaravel\Traits\InitializeTraits` 这个工具包，将初始化能力引入到 `Trait` 中。这样，我们就可以在使用 `Trait` 时轻松地进行初始化操作，提高代码的可读性和可维护性。

当我们在目标类上引入了 `InitializeTraits` 后，这个类上的其他 `Trait` 就可以以 `initialize + trait名称` 的方式来定义一个初始化方法。例如，如果有一个名为 `RecordLog` 的 `Trait`，那么其对应的初始化方法就是 `initializeRecordLog` ：

``` php
<?php

use Yesccx\BetterLaravel\Traits\InitializeTraits;

trait RecordLog {

    protected \Illuminate\Log\Logger $logger;

    public function initializeRecordLog()
    {
        $this->logger = app(\Illuminate\Log\Logger::class);
    }

    public function record(string $message)
    {
        $this->logger->info($message);
    }
}

class User {
    use InitializeTraits, RecordLog;
}

$user = new User;
$user->record('test');
```

上述代码中，我们引入了 `RecordLog Trait` 来为 `User` 类添加记录日志的功能。同时，`RecordLog Trait` 通过定义 `initializeRecordLog` 方法来进行相关初始化。这种能力的实现原理依赖于 `InitializeTraits` 中的构造函数。但是，如果目标类本身已经存在构造函数，我们就需要进行特殊处理，以防止 `InitializeTraits` 中的构造函数被目标类中的构造函数所覆盖。

为了解决这个问题，我们可以在目标类中手动调用 `InitializeTraits` 中的构造函数，以确保所有的初始化逻辑都得到正确执行。例如，我们可以在目标类中做以下调整：

``` php
class User {
    use InitializeTraits {
        __construct as __traitConstruct;
    }, RecordLog;

    public function __construct()
    {
        $this->__traitConstruct();
    }
}
```

## BaseService

`Better-Laravel` 中提供了 `Service` 层基类 `Yesccx\BetterLaravel\Service\BaseService`，其中引入了 `InstanceMake Trait`。

业务项目开发过程中，可以示情况进行继承使用。

## 辅助方法

### dumps

类似 `Laravel` 中的 `dump` 方法，输出更精简的信息

``` php
/**
 * dump wrapper
 * PS: 自动对集合做toArray
 *
 * @param mixed $vars
 *
 * @return void
 */
function dumps(mixed ...$vars): void;
```

### dds

类似 `Laravel` 中的 `dd` 方法，输出更精简的信息

``` php
/**
 * dd wrapper
 * PS: 自动对集合做toArray
 *
 * @param mixed $vars
 *
 * @return void
 */
function dds(mixed ...$vars): void;
```

### explode_str_array

分割字符串数组

``` php
/**
 * 分割字符串数组
 *
 * @param string $str
 * @param string $separator 分割符(默认,)
 *
 * @return array
 */
function explode_str_array(string $str, string $separator = ','): array;
```

示例如下：

``` php
$arr = explode_str_array('a,b,c');
// ["a", "b", "c"]
```

# 数据库

## 分页查询

在 `Laravel` 中，我们可以使用 `paginate`、`simplePaginate` 等方法进行分页查询。但是这些方法返回的结果包含了一些非必要的信息，并且其数据结构与常规的 `API` 响应结构不一致。

为了解决这些问题，我们可以使用 `Better-Laravel` 提供的分页方法：`customPaginate` 和 `customSimplePaginate`。这些方法的底层实现来自于 `Illuminate\Pagination\LengthAwarePaginator`，并最终由 `BuilderMarco` 扩展至 `Builder` 类上。这意味着您可以以模型链式调用的方式进行调用。

使用 `customPaginate` 和 `customSimplePaginate` 方法可以帮助我们更好地控制分页结果，并将其转换为符合常规 `API` 响应结构的格式。此外，这些方法还允许我们轻松自定义分页查询的参数，以满足不同场景下的需求。

> 如果需要进行深度定制，比如重新定义分页输出结构，我们可以通过重写 `Yesccx\BetterLaravel\Database\CustomLengthAwarePaginator` 类的相关方法，并在 `better-laravel.binds` 配置文件中重新定义映射关系。

### 普通分页查询

如果想在 `Better-Laravel` 中进行普通分页查询，我们可以使用 `customPaginate` 方法。以下是一个示例参考：

```php
$list = User::query()->where('status', 1)->customPaginate();
```

``` json
{
    "message": "操作成功",
    "code": 200,
    "data": {
        "paginate": {
            "total": 1,
            "current_page": 1,
            "current_count": 1,
            "page_size": 15
        },
        "list": [
            {
                "id": 1,
                "name": "张三"
            }
        ]
    }
}
```

默认情况下，`customPaginate` 方法会自动从请求中获取 `per_page` 作为每页数量参数，`page` 作为页码参数。如果将 `allowFetchAll` 参数设置为 `true`，则还会额外接收来自请求中的 `fetch_all` 参数，当 `fetch_all` 为 `true` 时，会获取满足条件的所有数据而不进行分页查询。这个功能在为前端提供类似“下拉框数据源接口”时非常有用。

``` php
$list = User::query()->where('status', 1)->customPaginate(true);

// http://localhost/api/user/list?fetch_all=1
// {
//     "message": "操作成功",
//     "code": 200,
//     "data": {
//         "list": [
//             {
//                 "id": 1,
//                 "name": "张三"
//             },
//             ....
//         ]
//     }
// }

// http://localhost/api/user/list
// {
//     "message": "操作成功",
//     "code": 200,
//     "data": {
//         "paginate": {
//             "total": 0,
//             "current_page": 1,
//             "current_count": 0,
//             "page_size": 15
//         },
//         "list": [
//             {
//                 "id": 1,
//                 "name": "张三"
//             },
//             ....
//         ]
//     }
// }
```

通过上述代码的实现，我们只需要提供一个 `user/list` 接口，即可既满足用户列表的分页展示，也满足前端需要查看并选择所有用户的场景。这样可以避免出现重复的接口，提高接口的复用性和可维护性。

> ！！需要注意的是，在实际开发中，为了避免影响数据库性能和接口响应速度，我们需要更具体地限制这种查询能力的使用。尤其是在数据量大的情况下，如果滥用这个功能将会给数据库带来极大的压力；

当我们需要自定义 `per_page` 和 `page` 参数值时，可以手动将这些参数传入 `customPaginate` 方法。此时方法会使用手动传入的参数值来进行分页查询，而覆盖默认从请求中获取参数的行为；

更多参数配置参考下面的方法签名：

``` php
/**
 * 自定义分页
 *
 * @param bool $allowFetchAll 是否允许获取全部
 * @param null|int $perPage 每页数量
 * @param null|int $page 页码
 * @param bool $forceFetchAll 是否强制获取全部
 * @param array $options 扩展选项 @see PaginatorOptions::data
 * @return CustomLengthAwarePaginatorContract
 */
function (
    bool $allowFetchAll = false,
    ?int $perPage = null,
    ?int $page = null,
    bool $forceFetchAll = false,
    array $options = []
): CustomLengthAwarePaginatorContract;
```

### 简单分页查询

与 `Laravel` 中的 `simplePaginate` 方法对应，`Better-Laravel` 中也提供了简单分页查询方法 `customSimplePaginate`，该方法与 `customPaginate` 的用法和原理非常相似。

更多参数配置参考下面的方法签名：

``` php
/**
 * 自定义简单分页
 *
 * @param bool $allowFetchAll 是否允许获取全部
 * @param null|int $perPage 每页数量
 * @param null|int $page 页码
 * @param bool $forceFetchAll 是否强制获取全部
 * @param array $options 扩展选项 @see PaginatorOptions::data
 * @return CustomPaginatorContract
 */
function (
    bool $allowFetchAll = false,
    ?int $perPage = null,
    ?int $page = null,
    bool $forceFetchAll = false,
    array $options = []
): CustomPaginatorContract;
```

### 自定义分页数据

当我们需要用自己的数据进行分页时，可以使用 `CustomLengthAwarePaginator` 分页器来生成标准分页器对象。这个分页器提供了一个静态方法 `resolve`，用法与 `customPaginate` 方法类似，同样的也可以手动传入 `per_page` 、`page` 、`fetch_all` 等参数，示例如下：

``` php
$list = \Yesccx\BetterLaravel\Database\CustomLengthAwarePaginator::resolve(items: [], total: 30, perPage: 15, page: 1);
```

### 空分页

有时候我们需要构造一个空的分页对象，比如在某些特定场景下，如果接口返回空数据或者查询结果为空，我们需要构造一个空的分页器对象来给前端展示，这时可以使用 `CustomLengthAwarePaginator` 分页器中的静态方法 `toEmpty` 来构造一个不进行实际查询的空分页对象。示例如下：

``` php
$list = \Yesccx\BetterLaravel\Database\CustomLengthAwarePaginator::toEmpty();
```

## Builder查询

`Better-Laravel` 中为 `Builder` 类扩展了更多的查询方法，这些方法都是通过 `marco` 进行扩展，因此也支持查询方法链式调用，示例如下：

``` php
// 通过模型类，查询注册时间是当日的用户
User::query()->where('status', 1)->whereToday('register_time')->first();

// 通过DB类，查询注册时间是当日的用户
DB::table('users')->where('status', 1)->whereToday('register_time')->first();
```

### customPaginate

自定义分页

``` php
/**
 * 自定义分页
 *
 * @param bool $allowFetchAll 是否允许获取全部
 * @param null|int $perPage 每页数量
 * @param null|int $page 页码
 * @param bool $forceFetchAll 是否强制获取全部
 * @param array $options 扩展选项 @see PaginatorOptions::data
 * @return CustomLengthAwarePaginatorContract
 */
function (
    bool $allowFetchAll = false,
    ?int $perPage = null,
    ?int $page = null,
    bool $forceFetchAll = false,
    array $options = []
): CustomLengthAwarePaginatorContract;
```

### customSimplePaginate

自定义简单分页

``` php
/**
 * 自定义简单分页
 *
 * @param bool $allowFetchAll 是否允许获取全部
 * @param null|int $perPage 每页数量
 * @param null|int $page 页码
 * @param bool $forceFetchAll 是否强制获取全部
 * @param array $options 扩展选项 @see PaginatorOptions::data
 * @return CustomPaginatorContract
 */
function (
    bool $allowFetchAll = false,
    ?int $perPage = null,
    ?int $page = null,
    bool $forceFetchAll = false,
    array $options = []
): CustomPaginatorContract;
```

### whereLike

LIKE查询

``` php
/**
 * LIKE查询
 *
 * @param mixed $fields 查询字段
 * @param mixed $keywords 查询值
 * @param int $mode 0-all;1-start;2-end;3-normal
 *
 * @return Builder
 */
function (mixed $fields, mixed $keywords, int $mode = 0): Builder;
```

### whenLike

(when)LIKE查询

``` php
/**
 * (when)LIKE查询
 *
 * @param mixed $fields 查询字段
 * @param mixed $keywords 查询值
 * @param int $mode 0-all 1-start 2-end 3-normal
 *
 * @return Builder
 */
function (mixed $fields, mixed $keywords, int $mode = 0): Builder;
```

### whereToday

查询是否为当日

``` php
/**
 * 查询是否为当日
 *
 * @uses whereThisDay()
 *
 * @param mixed $field 查询字段
 *
 * @return Builder
 */
function (mixed $field): Builder;
```

### whereThisDay

查询是否为当日，为 [whereToday](#whereToday) 的别名方法

### whereInDay

查询是否为某日

``` php
/**
 * 查询是否为某日
 *
 * @param mixed $field 查询字段
 * @param mixed $month 日期 2022-01-01
 *
 * @return Builder
 */
function (mixed $field, mixed $day): Builder;
```

### whereThisWeek

查询是否为本周

``` php
/**
 * 查询是否为本周
 *
 * @param mixed $field 查询字段
 *
 * @return Builder
 */
function (mixed $field): Builder;
```

### whereThisMonth

查询是否为本月

``` php
/**
 * 查询是否为本月
 *
 * @param mixed $field 查询字段
 *
 * @return Builder
 */
function (mixed $field): Builder;
```

### whereInMonth

查询是否为某月

``` php
/**
 * 查询是否为某月
 *
 * @param mixed $field 查询字段
 * @param mixed $month 月份 2022-01
 *
 * @return Builder
 */
function (mixed $field, mixed $month): Builder;
```

### whereThisYear

查询是否为本年

``` php
/**
 * 查询是否为本年
 *
 * @param mixed $field 查询字段
 *
 * @return Builder
 */
function (mixed $field): Builder;
```

### whereInYear

查询是否为某年

``` php
/**
 * 查询是否为某年
 *
 * @param mixed $field 查询字段
 * @param mixed $year 年份 2022
 *
 * @return Builder
 */
function (mixed $field, mixed $year): Builder;
```

### whereGtDate

查询是否大于指定日期

``` php
/**
 * 查询是否大于指定日期
 *
 * @param mixed $field 查询字段
 * @param mixed $date 日期(默认为当前时间)
 *
 * @return Builder
 */
function (mixed $field, mixed $date = null): Builder;
```

### whereGteDate

查询是否大于等于指定日期

``` php
/**
 * 查询是否大于等于指定日期
 *
 * @param mixed $field 查询字段
 * @param mixed $date 日期(默认为当前时间)
 *
 * @return Builder
 */
function (mixed $field, mixed $date = null): Builder;
```

### whereLtDate

查询是否小于指定日期

``` php
/**
 * 查询是否小于指定日期
 *
 * @param mixed $field 查询字段
 * @param mixed $date 日期(默认为当前时间)
 *
 * @return Builder
 */
function (mixed $field, mixed $date = null): Builder;
```

### whereLteDate

查询是否小于等于指定日期

``` php
/**
 * 查询是否小于等于指定日期
 *
 * @param mixed $field 查询字段
 * @param mixed $date 日期(默认为当前时间)
 *
 * @return Builder
 */
function (mixed $field, mixed $date = null): Builder;
```

### whereBetweenDate

查询是在指定日期范围内

``` php
/**
 * 查询是在指定日期范围内
 *
 * @param mixed $field 查询字段
 * @param mixed $startDate 开始日期
 * @param mixed $endDate 结束日期
 * @param bool $forceFullDay 是否为强制全天
 *
 * @return Builder
 */
function (string $field, mixed $startDate = null, mixed $endDate = null, bool $forceFullDay = false): Builder;
```

# HTTP

## 请求响应(Responser)

针对常见的接口开发场景，封装了快速响应 `成功`、`失败`、`异常`、`数据` 等方法，并统一了响应结构：

``` json
{
    "code": 200,
    "message": "响应成功",
    "data": {},
}
```

> 如果想调整默认响应结构或扩展其功能，可以对 `\Yesccx\BetterLaravel\Http\Responder` 类进行重写，并在 `better-laravel.binds` 配置文件中重新定义映射关系。

### responseSuccess

响应成功信息

``` php
/**
 * 响应成功信息
 *
 * @param mixed $message 响应信息
 * @param mixed $data 响应数据
 * @param mixed $code 响应码
 * @param array $headers 响应头
 * @param int $options
 *
 * @return JsonResponse
 */
responseSuccess(
    mixed $message = ResponseCode::SUCCESS_MESSAGE,
    mixed $data = [],
    mixed $code = ResponseCode::SUCCESS_CODE,
    array $headers = [],
    int $options = 0
): JsonResponse;
```

### responseError

响应失败信息

``` php
/**
 * 响应失败信息
 *
 * @param mixed $message 响应信息
 * @param mixed $code 响应码
 * @param mixed $data 响应数据
 * @param array $headers 响应头
 * @param int $options
 *
 * @return JsonResponse
 */
responseError(
    mixed $message = ResponseCode::ERROR_MESSAGE,
    mixed $code = ResponseCode::ERROR_CODE,
    mixed $data = [],
    array $headers = [],
    int $options = 0
): JsonResponse;
```

### responseData

响应数据信息

``` php
/**
 * 响应数据信息
 *
 * @param mixed $data 响应数据
 * @param string|bool $resource 是否使用资源类
 * @param mixed $message 响应信息
 * @param bool $isCollection 是否按集合处理，默认根据响应数据类型判断
 * @param mixed $code 响应码
 * @param array $headers 响应头
 * @param int $options
 *
 * @return JsonResponse
 */
responseData(
    mixed $data = [],
    string|bool $resource = false,
    mixed $message = ResponseCode::SUCCESS_MESSAGE,
    bool $isCollection = false,
    mixed $code = ResponseCode::SUCCESS_CODE,
    array $headers = [],
    int $options = 0
): JsonResponse;
```

### responseException

响应异常信息

``` php
/**
 * 响应异常信息
 *
 * @param \Throwable $e
 * @param array $options
 *
 * @return JsonResponse
 */
public function responseException(\Throwable $e, array $options = []): JsonResponse;
```

## 控制器基类

控制器是 `Laravel` 中的核心组件之一，其在 `HTTP` 请求处理过程中扮演着至关重要的角色。控制器通常需要接收请求参数、执行相应的逻辑并将结果返回给客户端。为了更好地实现快速接口开发，我们可以利用 `Better-Laravel` 中的控制器基类 `Yesccx\BetterLaravel\Http\BaseController`。

`Yesccx\BetterLaravel\Http\BaseController` 基类封装了诸多常用的功能方法，包括：
- `快速响应数据`：提供了 `responseSuccess`、`responseError` 和 `responseData` 等方法，可以方便地进行标准化的响应操作；
- `入参类型转换`：提供了 `fetch`、`fetchAll` 等方法，可以在获取参数的同时进行类型转换。

使用 `Yesccx\BetterLaravel\Http\BaseController` 基类能够有效地提高代码可读性和可维护性，同时也可以简化接口开发的过程。

### 接口响应(Response)

当业务控制器继承基类 `Yesccx\BetterLaravel\Http\BaseController` 后，可以直接调用由 [`Responser`](#请求响应(Responser)) 提供的相关方法，示例如下：

``` php
<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use Yesccx\BetterLaravel\Http\BaseController;
use Illuminate\Http\Request;
use App\Models\User;

final class UserController extends BaseController
{
    public function info(Request $request): \Illuminate\Http\JsonResponse
    {
        $id = $request->get('id', 0);
        if (empty($id)) {
            // 响应失败信息
            return $this->responseError('参数错误');
        }

        $user = User::query()->find($id);
        if (empty($user)) {
            // 响应成功信息
            return $this->responseSuccess('用户暂未注册')
        }

        // 响应数据
        return $this->responseData($user);
    }
}
```

如果响应的数据还需要经过 `Resource` 处理，我们可以直接将 `Resource` 类及数据传递给 `responseData` 方法，这样做可以在响应数据之前进行进一步的加工和处理，示例如下：

``` php
$this->responseData($user, UserResource::class);
```

当响应的数据是二维数组或者集合时，我们可以通过额外的参数决定以 `资源集合` 的方式进行处理，但当数据由分页器查询返回时，可以不需要手动指定，`responseData` 方法内部会自动识别并以  `资源集合` 的方式进行处理。示例如下：

``` php
$this->responseData($userList, UserResource::class, isCollection: true);

// 分页查询的结果不需要额外声明isCollection
$userList = User::query()->customPaginate();
$this->responseData($userList, UserResource::class);
```

### 入参类型转换(TypeTransfrom)

通常我们在定义方法时都会声明其参数类型，所以往往我们在获取到 `Http` 请求参数后，都会显式的对其进行类型转换，以符合相关方法的调用要求。在 `Laravel` 中，我们可以通过 `Request` 类的 `get`、`input` 等方法获取入参，并手动将其转换为指定类型，如下所示：

``` php
$userid = (int) request()->get('userid', 0);
$phone = (string) request()->get('phone', '');
```

`Better-Laravel` 中提供了获取参数并转换其类型的简写方式，通过 `fetch` 方法我们可以轻松的获取转换后的参数，同时也支持传入默认值，示例如下:

``` php
$userid = request()->fetch('user_id/d', 0);
$phone = request()->fetch('phone/s', '');
```

默认情况下，`fetch` 方法会通过 `request()->all()` 获取作为数据源。但是，如果我们已经有了处理好的数据源，也可以通过 `fetch` 方法的第三个参数来传入：

``` php
$userid = request()->fetch(
    'user_id/d',
    0,
    ['userid' => 123]
);
```

同时还支持通过 `fetchMany` 方法进行批量获取：

```php
$data = request()->fetchMany([
    'user_id/d' => 0,
    'phone/s' => '',

    // 不指定默认值时，默认为null
    'summary/s'
]);
```

> 也允许通过第2个参数自定义数据源。


支持的类型及简写说明参考如下：

| 类型   | 语法      |
| ------ | --------- |
| 数组   | (a)array  |
| 数值   | (n)number |
| 整数   | (i)int    |
| 浮点数 | (f)float  |
| 布尔   | (b)bool   |
| 字符串 | (s)string |
| JSON   | (j)json   |

## 表单验证

`Laravel` 提供了多种验证传入应用程序的数据的方法。为确保安全性和规范性，建议为每个需要验证入参的接口创建表单验证类。

### 表单验证基类

基于常见的开发场景，`Better-Laravel` 中已经准备好了表单验证基类 `Yesccx\BetterLaravel\Validation\BaseRequest`，用于快速创建可用的表单验证类。该基类默认开启了 `stopOnFirstFailure` 选项，表示在验证器验证的过程中遇到第一个规则失败时即停止，同时将表单请求授权验证 `authorize` 默认为通过。此外，还可以使用 `fetch` 或 `fetchMany` 方法，从验证通过的数据中获取并转换数据类型，这种能力继承自 `Request`。

以下示例通过继承基类 `BaseRequest` 定义业务验证类：

``` php
<?php

final class AccountLoginRequest extends BaseRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => ['bail', 'required', 'string', 'min:1'],
            'password' => ['bail', 'required', 'string', 'min:1'],
        ];
    }
}

public function login(AccountLoginRequest $request)
{
    $data = $request->fetchMan([
        'username/s' => '',
        'password/s' => ''
    ]);

    // Do something ...
}
```

### 验证场景

为了减少验证规则类的重复定义，提高利用性，我们可以在表单验证类中定义验证场景。通过验证场景我们只需要在同一个验证类中定义好所有字段验证规则，再针对不同场景制定不同的验证字段。

首先我们需要定义一个验证类，继承 `Yesccx\BetterLaravel\Validation\BaseRequest` 基类并引入 `Yesccx\BetterLaravel\Validation\Traits\ValidatorScenes`，再在验证类中定义验证场景方法 `scenes`：

``` php
<?php

use Yesccx\BetterLaravel\Validation\BaseRequest;
use Yesccx\BetterLaravel\Validation\Traits\ValidatorScenes;

final class UserRequest extends BaseRequest
{
    use ValidatorScenes;

    /**
     * 验证场景
     *
     * @return array
     */
    public function scenes(): array
    {
        return [
            'create' => [
                'username', 'password', 'nickname', 'introduction'
            ],
            'update' => [
                'nickname', 'introduction'
            ]
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'username'      => '用户名',
            'password'      => '密码',
            'nickname'      => '昵称',
            'introduction'  => '简介'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'      => ['bail', 'required', 'string', 'min:1'],
            'password'      => ['bail', 'required', 'string', 'min:1'],
            'nickname'      => ['bail', 'nullable', 'string', 'min:1'],
            'introduction'  => ['bail', 'nullable', 'string', 'min:1'],
        ];
    }
}
```

在上述代码中，声明了两个验证场景 `create` 和 `update`。在请求进入控制器方法后，会识别当前控制器方法名作为当前场景名，并从验证类中找出对应验证场景的字段进行验证。示例如下：

``` php
<?php

class UserController
{
    public function create(UserRequest $request)
    {
        // 此处会验证  'username', 'password', 'nickname', 'introduction' 字段
        // Do something ...
    }

    public function update(UserRequest $request)
    {
        // 此处仅验证 'nickname', 'introduction' 字段
        // Do something ...
    }
}
```

同时我们还可以为验证场景中的字段单独声明验证规则，这些规则将覆盖字段在 `rules` 中声明的规则：

``` php
/**
 * 验证场景
 *
 * @return array
 */
public function scenes(): array
{
    return [
        'create' => [
            'username', 'password', 'nickname', 'introduction'
        ],
        'update' => [
            // 此处对 nickname 字段重新声明了验证规则
            'nickname' => ['bail', 'required', 'max:32'],

            'introduction'
        ]
    ];
}
```


## 验证规则

### ArrayIdsRule

数组id集验证

``` php
/**
 * @param bool $allowZero 值允许为0
 * @param bool $allowNegativeNumber 值允许为负数
 * @param bool $allowFloatNumber 值允许浮点数
 * @param bool $allowRepeat 值允许重复
 *
 * @return void
 */
public function __construct(
    protected bool $allowZero = false,
    protected bool $allowNegativeNumber = false,
    protected bool $allowFloatNumber = false,
    protected bool $allowRepeat = false
);
```

### Base64Rule

base64验证

### IdCardRule

身份证号验证

### LandlinePhoneRule

固定电话验证

### PhoneRule

手机号验证

### StringArrayIdsRule

字符串数组id集验证

``` php
/**
 * @param string $separator 分隔符
 * @param bool $allowZero 值允许为0
 * @param bool $allowNegativeNumber 值允许为负数
 * @param bool $allowFloatNumber 值允许浮点数
 * @param bool $allowRepeat 值允许重复
 *
 * @return void
 */
public function __construct(
    protected string $separator = ',',
    protected bool $allowZero = false,
    protected bool $allowNegativeNumber = false,
    protected bool $allowFloatNumber = false,
    protected bool $allowRepeat = false
);
```

### SubManyRequestRule

子表单集合验证

``` php
/**
 * @param string $subRequest 子验证类
 *
 * @return void
 */
public function __construct(
    protected string $subRequest
);
```

### SubRequestRule

子表单验证

``` php
/**
 * @param string $subRequest 子验证类
 *
 * @return void
 */
public function __construct(
    protected string $subRequest
);
```

# 配置项

`Better-Laravel` 的配置文件为 `better-laravel.php`，其中包含了 `异常处理`、`类依赖关系`、`默认时间格式` 等配置项。

## date_format

配置默认时间格式化，该格式将应用于以下内容：

- `Carbon` 类的默认时间格式
- `Model` 中的默认时间输出格式

## http.route_scanning

定义 `模块路由` 的扫描文件夹，可以定义多个。同时支持通过 `options` 配置路由参数。

待补充完善...

# 使用建议

待补充完善...

# License

MIT
