## 项目概述

* 产品名称：写 Laravel 测试代码实践
* 项目代号：l5test
* 官方地址：

学习 [写 Laravel 测试代码 (一)](https://learnku.com/articles/5053/write-the-laravel-test-code-1) 教程，将里面的
其中的举例代码放入当前项目中

## 功能如下

- 无

## 运行环境要求

- Apache 2.1+
- PHP 7.1+
- Mysql 5.7+

## 开发环境部署/安装

本项目代码使用 PHP 框架 [Laravel 5.5](https://learnku.com/docs/laravel/5.5/) 开发，本地开发环境使用 [Laravel Homestead](https://learnku.com/docs/laravel/5.5/homestead)。

下文将在假定读者已经安装好了 Homestead 的情况下进行说明。如果您还未安装 Homestead，可以参照 [Homestead 安装与设置](https://learnku.com/docs/laravel/5.5/homestead#installation-and-setup) 进行安装配置。

### 基础安装

#### 1. 克隆源代码

克隆 `l5test` 源代码到本地：

    > git clone https://github.com/wakasann/study-write-laravel-test.git

#### 2. 配置本地的 Homestead 环境(非Homestead环境，可跳过)

1). 运行以下命令编辑 Homestead.yaml 文件：

```shell
homestead edit
```

2). 加入对应修改，如下所示：

```
folders:
    - map: ~/my-path/l5test/ # 你本地的项目目录地址
      to: /home/vagrant/l5test

sites:
    - map: l5test.test
      to: /home/vagrant/l5test/public

databases:
    - ltest
```

3). 应用修改

修改完成后保存，然后执行以下命令应用配置信息修改：

```shell
homestead provision
```

随后请运行 `homestead reload` 进行重启。

#### 3. 安装扩展包依赖

	composer install

#### 4. 生成配置文件

```
cp .env.example .env
```

你可以根据情况修改 `.env` 文件里的内容，如数据库连接、缓存、邮件设置等：

```
APP_URL=http://l5test.test
...
DB_HOST=localhost
DB_DATABASE=ltest
DB_USERNAME=homestead
DB_PASSWORD=secret

```

#### 5. 生成数据表及生成测试数据

在 Homestead 的网站根目录下运行以下命令

```shell
$ php artisan migrate --seed
```

初始的用户角色权限已使用数据迁移生成。

重新填充数据，可运行一下命令，会重新生成表和填充数据进DB：

```shell
php artisan migrate:refresh --seed
```

#### 7. 生成秘钥

```shell
php artisan key:generate
```

#### 8. 配置 hosts 文件

    echo "192.168.10.10   l5test.test" | sudo tee -a /etc/hosts


#### 生成 jwt密钥 

```
php artisan jwt:secret
```

#### 测试部分数据填充 

在 MySql中添加测试使用的用户和赋予权限

```
CREATE USER 'testing'@'localhost' IDENTIFIED BY 'testing';
GRANT ALL ON `ltest%`.* TO 'testing'@'localhost';
```

单表或多表数据填充

```
php artisan db:seed --class=SimpleYamlSeeder --tables=users
```

如上面的命令，是只填充`users`表的记录

`--tables` 参数支持1个或多余1个数据表名称，多余1个数据表表名之间使用逗号分割，如`users,posts`

刷新phpunit數據

```
phpunit -d rebase
```
