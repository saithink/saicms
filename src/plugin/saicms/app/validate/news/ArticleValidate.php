<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: your name
// +----------------------------------------------------------------------
namespace plugin\saicms\app\validate\news;

use think\Validate;

/**
 * 文章管理验证器
 */
class ArticleValidate extends Validate
{
    /**
     * 定义验证规则
     */
    protected $rule =   [
        'category_id' => 'require',
        'title' => 'require',
        'content' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message  =   [
        'category_id' => '文章分类必须填写',
        'title' => '文章标题必须填写',
        'content' => '文章内容必须填写',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'save' => [
            'category_id',
            'title',
            'content',
        ],
        'update' => [
            'category_id',
            'title',
            'content',
        ],
    ];

}
