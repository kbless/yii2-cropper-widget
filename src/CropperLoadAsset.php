<?php

namespace potime\cropper;


use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author potime <ivan@potime.com>
 */
class CropperLoadAsset extends AssetBundle
{
    public $sourcePath = '@potime/cropper/assets';
    public $jsOptions = ['position' => View::POS_LOAD];
    public $css = [
        'cropper.css',
    ];
    public $js = [
        'cropper.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}