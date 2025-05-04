<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: your name
// +----------------------------------------------------------------------
namespace plugin\saicms\app\logic\news;

use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\utils\Helper;
use plugin\saicms\app\model\news\ArticleCategory;

/**
 * 文章分类逻辑层
 */
class ArticleCategoryLogic extends BaseLogic
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new ArticleCategory();
    }

    /**
     * 修改数据
     * @param $id
     * @param $data
     * @return mixed
     */
    public function edit($id, $data): mixed
    {
        if (!isset($data['parent_id'])) {
            $data['parent_id'] = 0;
        }
        if ($data['parent_id'] == $data['id']) {
            throw new ApiException('不能设置父级为自身');
        }
        return parent::edit($id, $data);
    }

    /**
     * 删除数据
     * @param $ids
     */
    public function destroy($ids)
    {
        $num = $this->model->where('parent_id', 'in', $ids)->count();
        if ($num > 0) {
            throw new ApiException('该分类下存在子分类，请先删除子分类');
        } else {
            parent::destroy($ids);
        }
    }

    /**
     * 树形数据
     */
    public function tree($where)
    {
        $query = $this->search($where);
        if (request()->input('tree', 'false') === 'true') {
            $query->field('id, id as value, category_name as label, parent_id');
        }
        $data = $this->getAll($query);
        return Helper::makeTree($data);
    }

}
