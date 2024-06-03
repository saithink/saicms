<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: your name
// +----------------------------------------------------------------------
namespace plugin\saicms\app\controller\news;

use plugin\saiadmin\basic\BaseController;
use plugin\saicms\app\logic\news\ArticleCategoryLogic;
use plugin\saicms\app\validate\news\ArticleCategoryValidate;
use support\Request;
use support\Response;

/**
 * 文章分类控制器
 */
class ArticleCategoryController extends BaseController
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->logic = new ArticleCategoryLogic();
        $this->validate = new ArticleCategoryValidate;
        parent::__construct();
    }

    /**
     * 数据列表
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $where = $request->more([
            ['category_name', ''],
            ['create_time', ''],
        ]);
        $data = $this->logic->tree($where);
        return $this->success($data);
    }

}
