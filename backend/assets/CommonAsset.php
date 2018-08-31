<?php
namespace backend\assets;

use yii\web\AssetBundle;

/**
*	静态资源加载公共类
*	2018/08/22
*
*/
class CommonAsset extends AssetBundle
{
	public $basePath	= '@webroot';//指定资源文件目录
	public $baseUrl		= '@web';//资源目录对应的url

	//css 文件数组
	public $css = [
		'plugin/element-ui@2.4.6/index.css',
		'css/base.css',
		'css/common.css',
	];

	//js 文件数组
	public $js = [
		'js/vue.2.5.17.js',
		'plugin/element-ui@2.4.6/index.js',
	];

	/**
	*	js 文件加载位置
	*	'position' => \yii\web\View::POS_HEAD 	head头部
	*	'position' => \yii\web\View::POS_BEGIN 	body开始的位置
	*	'position' => \yii\web\View::POS_END 	body结束的位置
	*	'position' => \yii\web\View::POS_READY 	在jQuery(document).ready()中 （dom结构加载完触发）
	*	'position' => \yii\web\View::POS_LOAD 	在jQuery(window).load()中	（需要页面完全加载完触发）
	*/
	public $jsOptions = [
		'position'	=>	\yii\web\View::POS_HEAD,
	];
	/**
	*	depends 依赖关系
	*	css/js 文件加载时会依赖其他文件，必须其他文件加载后，再加载才不会报变量为定义等错误
	*	使用depends 数组先加载依赖关系文件。
	*	(文件加载顺序：依赖关系数组中的文件－>css/js数组中的文件（这些文件按照数组中的顺序自上而下的加载）)
	*/
	public $depends = [
		'yii\web\JqueryAsset',//包含从jQuery bower 包的jquery.js文件。
		//'yii\web\YiiAsset',//主要包含yii.js 文件，该文件完成模块JavaScript代码组织功能
		'yii\bootstrap\BootstrapAsset',//包含从Twitter Bootstrap 框架的CSS文件。
		//'yii\bootstrap\BootstrapPluginAsset',//包含从Twitter Bootstrap 框架的JavaScript 文件 来支持Bootstrap JavaScript插件。
	];




	/**
	*	定义按需加载JS方法，注意加载顺序在最后
	*	视图页面：只在该视图中使用非全局的jui
	*	实例：TestAsset::addScript($this,'@web/js/jquery-ui.custom.min.js');
	*
	*/
    // public static function addScript($view, $jsfile) {
    //     $view->registerJsFile($jsfile, [CommonAsset::className(), 'depends' => 'backend/assets/CommonAsset']);
    // }

   //定义按需加载css方法，注意加载顺序在最后  同上
    // public static function addCss($view, $cssfile) {
    //     $view->registerCssFile($cssfile, [CommonAsset::className(), 'depends' => 'backend\assets\CommonAsset']);
    // }
}
