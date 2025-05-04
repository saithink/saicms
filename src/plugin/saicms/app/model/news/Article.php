<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: your name
// +----------------------------------------------------------------------
namespace plugin\saicms\app\model\news;

use plugin\saiadmin\basic\BaseModel;

/**
 * 文章管理模型
 */
class Article extends BaseModel
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
    protected $table = 'sa_article';

    /**
     * 文章标题 搜索
     */
    public function searchTitleAttr($query, $value)
    {
        $query->where('title', 'like', '%'.$value.'%');
    }

    /**
     * 文章分类 搜索
     */
    public function searchCategoryIdAttr($query, $value)
    {
        if (is_array($value)) {
            $query->where('category_id', 'in', $value);
        } else {
            $query->where('category_id', $value);
        }
    }

    /**
     * 关联模型 category
     */
    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id', 'id');
    }

}
