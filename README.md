tp-swoole-chat
===============

> 运行环境要求PHP7.1+。
> 需要安装swoole拓展。
> 需要composer。
> 不支持windows环境。

## 主要功能

* 多人多房间聊天室

## 安装运行

clone代码 进入项目目录
~~~
composer install
php think swoole start
~~~
打开 `http://127.0.0.1:8080/static/index.html`

## 说明
~~~
tp-swoole-chat
|—— app
    |—— subscribe
        |—— Websocket.php // 核心业务代码
|—— config
    |—— swoole.php        // swoole配置文件
~~~

