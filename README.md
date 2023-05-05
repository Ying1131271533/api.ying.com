
注意：如果执行下面的命令提示：already exists (已经存在)  那就不用管了，下一步就行

安装扩展

```
$ composer install
```

创建 `.env` :

```
$ cp .env.example .env
```

修改 `.env` 配置，主要是数据库配置等

发布DingApi配置：

```
$ php artisan vendor:publish --provider="Dingo\Api\Provider\LaravelServiceProvider"
```

发布JWT配置:

```
$ php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"
```

生成JWT TOKEN：(可以不执行，因为.env已经有了)

```
$ php artisan jwt:secret
```

发布 迁移和config/permission.php 配置文件：(可以不执行，已经生成过了)

```
$ php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```


运行迁移同时填充数据：

```
$ php artisan migrate --seed
$ php artisan migrate:refresh --seed
$ php artisan migrate:fresh --seed
```







