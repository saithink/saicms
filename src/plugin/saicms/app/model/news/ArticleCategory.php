<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: your name
// +----------------------------------------------------------------------
namespace plugin\saicms\app\model\news;

use plugin\saiadmin\basic\BaseModel;

/**
 * 文章分类模型
 */
class ArticleCategory extends BaseModel
{

    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    /**
     * 数据库表名称
     * @var string
     */
    protected $table = 'eb_article_category';

    
    /**
     * 分类标题 搜索
     */
    public function searchCategoryNameAttr($query, $value)
    {
        $query->where('category_name', 'like', '%'.$value.'%');
    }
    
    /**
     * 创建时间 搜索
     */
    public function searchCreateTimeAttr($query, $value)
    {
        $query->whereTime('create_time', 'between', $value);
    }


}
