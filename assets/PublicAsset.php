<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class PublicAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/twbs-addons.css',
        'third/paper/assets/css/bootstrap.min.css',
        'third/paper/assets/css/paper-dashboard.css?v=1.2.1',
        'https://use.fontawesome.com/releases/v5.8.2/css/all.css',
        'third/paper/assets/css/themify-icons.css',
        'css/twbs-xl.css',
        'third/print/print.min.css',
        'https://fonts.googleapis.com/css?family=Comfortaa|Roboto+Condensed&display=swap',
        'css/public.css',
    ];

    public $js = [
        // 'third/md-pro-angular/assets/js/core/jquery-3.1.1.min.js',
        // 'js/main.js',
        'js/number_format.js',
        'js/jquery-ui.min.js',
        'js/jquery.validate.min.js',
        'js/jquery.perfect-scrollbar.min.js',
        'third/paper/assets/js/bootstrap.min.js',
        'third/paper/assets/js/bootstrap-notify.js',
        'third/paper/assets/js/bootstrap-switch-tags.js',
        'third/paper/assets/js/chartist.min.js',
        'third/paper/assets/js/paper-dashboard.js?v=1.2.1',
        'js/sweetalert2.min.js',
        'third/print/print.min.js',
        'js/buttons.js',
    ];
    public $depends = [
        
    ];
}
