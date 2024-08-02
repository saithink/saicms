<?php

use Webman\Route;
use plugin\saiadmin\app\middleware\SystemToken;

// 管理端接口
Route::group('/saicms', function () {
    // 注册文章管理路由
    fastRoute('/news/article',\plugin\saicms\app\controller\news\ArticleController::class);
    // 注册文章分类路由
    fastRoute('/news/category',\plugin\saicms\app\controller\news\ArticleCategoryController::class);
    // 注册文章轮播路由
    fastRoute('/news/banner',\plugin\saicms\app\controller\news\ArticleBannerController::class);

})->middleware([
    SystemToken::class,
]);


