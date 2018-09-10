<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## 项目介绍

 一个学习 Laravel 的项目，暂时完成文章，评论，用户模块基本功能。

## 项目部署基本操作

1. 克隆项目到本地目录  
   `git clone xxxx`   xxxx 为项目地址。  
    `cp ./.env.example ./.env`     复制配置文件  
    `vi ./.env`     编辑配置文件，修改必要配置项和数据库信息  

2. 安装依赖  
   `composer install`   框架依赖

3. 目录权限操作  
   `chmod -R 775 storage/`   
    `chown -R www-data:www-data /var/www/yourdir`  yourdir 为项目目录， www-data 为 nginx 用户   

4. 发布项目   
   `php artisan key:generate`    生成密钥   
   `php artisan migrate`    迁移数据库   
   `php artisan up`     项目上线   

5. 项目维护   
   本地完成修改 `git push origin master` 提交到仓库   

    进入服务器中的项目目录执行 `git pull` 拉取新文件   

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).