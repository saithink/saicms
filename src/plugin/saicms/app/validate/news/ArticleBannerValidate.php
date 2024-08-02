<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: your name
// +----------------------------------------------------------------------
namespace plugin\saicms\app\validate\news;

use think\Validate;

/**
 * 文章轮播验证器
 */
class ArticleBannerValidate extends Validate
{
    /**
     * 定义验证规则
     */
    protected $rule =   [
        'banner_type' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message  =   [
        'banner_type' => '类型必须填写',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'save' => [
            'banner_type',
        ],
        'update' => [
            'banner_type',
        ],
    ];

}
