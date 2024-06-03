<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: your name
// +----------------------------------------------------------------------
namespace plugin\saicms\app\controller\news;

use plugin\saiadmin\basic\BaseController;
use plugin\saicms\app\logic\news\ArticleBannerLogic;
use plugin\saicms\app\validate\news\ArticleBannerValidate;
use support\Request;
use support\Response;

/**
 * 文章轮播控制器
 */
class ArticleBannerController extends BaseController
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->logic = new ArticleBannerLogic();
        $this->validate = new ArticleBannerValidate;
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
            ['banner_type', ''],
            ['title', ''],
            ['status', ''],
        ]);
        $query = $this->logic->search($where);
        $data = $this->logic->getList($query);
        return $this->success($data);
    }

}
