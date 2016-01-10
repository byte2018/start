<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StartExt
 *
 * @author wangzhen
 */
include './Start/Start.class.php';
class StartExt extends Start{
    private $arrayConfig = array(
        'suffix' => '.s', //设置模板文件的后缀
        'left' => '<!--{', //左边定界符
        'right' => '}-->', //右边定界符
        'template' => 'template/', //设置模板所在的目录
        'complie' => 'template_c/', //设置模板编译后存放的目录
        'is_complie_cache' => false,//是否缓存编译后得文件
        'cache_html' => false, //是否生成静态文件
        'suffix_cache' => '.html', //设置编译文件的后缀
        'cache_complie_time' => 30, //设置多长时间自动更新,单位秒
        'cache_html_time' => 30 //设置多长时间自动更新html,单位秒
    );
   public function __construct($arrayConfig = array()) {
       parent::__construct($arrayConfig + $this->arrayConfig);
   }
}
