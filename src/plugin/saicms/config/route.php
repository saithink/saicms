<?php

use Webman\Route;
use plugin\saiadmin\app\middleware\SystemLog;
use plugin\saiadmin\app\middleware\CheckLogin;
use plugin\saiadmin\app\middleware\CheckAuth;

// 管理端接口
Route::group('/app/saicms', function () {
    // 注册文章管理路由
    fastRoute('/news/Article',\plugin\saicms\app\controller\news\ArticleController::class);
    // 注册文章分类路由
    fastRoute('/news/ArticleCategory',\plugin\saicms\app\controller\news\ArticleCategoryController::class);
    // 注册文章轮播路由
    fastRoute('/news/ArticleBanner',\plugin\saicms\app\controller\news\ArticleBannerController::class);

})->middleware([
    CheckLogin::class,
    CheckAuth::class,
    SystemLog::class,
]);


