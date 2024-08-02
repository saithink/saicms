<?php

namespace plugin\saicms\app\controller;

use Throwable;
use support\Request;
use support\Response;
use plugin\saiadmin\utils\Arr;
use plugin\saicms\app\logic\news\ArticleCategoryLogic;
use plugin\saicms\app\logic\news\ArticleLogic;
use plugin\saicms\app\logic\news\ArticleBannerLogic;

class IndexController
{
    /**
     * 模板变量
     * @var array
     */
    public $vars = [];

    public function __construct()
    {
        $this->init();
    }

    /**
     * 初始化
     * @return void
     */
    private function init()
    {
        $categoryLogic = new ArticleCategoryLogic();
        $list = $categoryLogic->where([
            'parent_id' => 0,
            'status' => 1
        ])->select()->toArray();
        $articleLogic = new ArticleLogic();
        $last = $articleLogic->where([
            'status' => 1
        ])->order('create_time', 'desc')->limit(3)->select()->toArray();
        $this->vars['lastArticle'] = $last;
        $this->vars['category'] = $list;
    }

    /**
     * 首页
     * @param Request $request
     * @return Response
     * @throws Throwable
     */
    public function index(Request $request): Response
    {
        $bannerLogic = new ArticleBannerLogic();
        $list = $bannerLogic->where([
            'banner_type' => 1,
            'status' => 1
        ])->select()->toArray();
        $this->vars['banner'] = $list;
        return raw_view('index/index', $this->vars);
    }

    /**
     * 分类
     * @param Request $request
     * @return Response
     * @throws Throwable
     */
    public function list(Request $request): Response
    {
        $id = $request->input('cid', '');
        $categoryLogic = new ArticleCategoryLogic();
        $model = $categoryLogic->where('id', $id)->findOrEmpty();
        if ($model->isEmpty()) {
            return new Response(404);
        }
        $list = $categoryLogic->where([
            'parent_id' => $id,
            'status' => 1
        ])->select()->toArray();
        $ids = Arr::getArrayColumn($list, 'id');
        $ids[] = $id;
        $articleLogic = new ArticleLogic();
        $query = $articleLogic->search([
            'category_id' => $ids,
            'status' => 1
        ]);
        $data = $articleLogic->getList($query);
        $this->vars['model'] = $model->toArray();
        $this->vars['list'] = $list;
        $this->vars['data'] = $data;
        return raw_view('article/list', $this->vars);
    }

    /**
     * 详情
     * @param Request $request
     * @return Response
     * @throws Throwable
     */
    public function article(Request $request): Response
    {
        $id = $request->input('id', '');
        $articleLogic = new ArticleLogic();
        $model = $articleLogic->where('id', $id)->findOrEmpty();
        if ($model->isEmpty()) {
            return new Response(404);
        }
        $model->views = $model->views + 1;
        $model->save();
        $this->vars['model'] = $model->toArray();
        return raw_view('article/article', $this->vars);
    }

    /**
     * 定价页面
     * @param Request $request
     * @return Response
     * @throws Throwable
     */
    public function price(Request $request): Response
    {
        return raw_view('price/index', $this->vars);
    }

}