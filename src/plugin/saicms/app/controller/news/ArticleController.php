<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: your name
// +----------------------------------------------------------------------
namespace plugin\saicms\app\controller\news;

use plugin\saiadmin\basic\BaseController;
use plugin\saicms\app\logic\news\ArticleLogic;
use plugin\saicms\app\validate\news\ArticleValidate;
use support\Request;
use support\Response;

/**
 * 文章管理控制器
 */
class ArticleController extends BaseController
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->logic = new ArticleLogic();
        $this->validate = new ArticleValidate;
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
            ['category_id', ''],
            ['title', ''],
            ['create_time', ''],
        ]);
        $query = $this->logic->search($where);
        $data = $this->logic->getList($query);
        return $this->success($data);
    }

}
