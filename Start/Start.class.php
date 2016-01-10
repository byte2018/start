<?php

/**
 * Start Template
 * 永久开源免费
 */

/**
 * 模板引擎基础类
 * 存放基本配置信息
 * @author wangzhen
 * @copyright (c) 2016, wangzhen
 * @version 0.0.1
 */
use Core\Classes\Compile;

class Start {

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
    private $value = array();
    private $compileTool;  //编译器
    public $file; //模板文件名
    static private $instance = null;
    
    
    

    public function __construct($arrayConfig = array()) {
        spl_autoload_register(array($this, 'registerClass')); //注册的自动装载函数
        $this->arrayConfig = $arrayConfig + $this->arrayConfig;
    }

    /**
     * 取得模板引擎实例
     *
     * @return obj
     * @access  public 
     * @static
     */
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Start();
        }
        return self::$instance;
    }

    /**
     * 单步设置引擎
     * @access public
     * @param string $key
     * @param mixed $value
     */
    public function setConfig($key, $value = null) {
        if (is_array($key)) {
            $this->arrayConfig = $key + $this->arrayConfig;
        } else {
            $this->arrayConfig[$key] = $value;
        }
    }

    /**
     * 获取当前配置信息
     * @access public
     * @param string $key
     * @return array
     */
    public function getConfig($key = null) {
        if ($key) {
            return $this->arrayConfig[$key];
        } else {
            return $this->arrayConfig;
        }
    }

    /**
     * 注入单个变量
     * 
     * @access public
     * @param string $key
     * @param mixed $value
     * @return  void
     */
    public function assign($key, $value) {
        $this->value[$key] = $value;
    }

    /**
     * 注入数组变量
     * 
     * 
     * @access public
     * @param array $array
     * @return  void
     */
    public function assignArray($array) {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $this->assign($key, $value);
            }
        }
    }

    /**
     * 获得模板文件路径
     * 
     * @access public
     * @return string
     */
    public function path() {

        return $this->arrayConfig['template'] . $this->file . $this->arrayConfig['suffix'];
    }

    /**
     * 编译并展示模板
     * 
     * @access public
     * @param string $file
     * @return void
     */
    public function show($file) {
       $complieFile = $this->compile($file);//编译模板
        
        include $complieFile;
    }
    
    
    /**
     * 编译模板
     * @param type $file
     * @return string
     */
    private function compile($file){
        
         $this->file = $file;

        if (!is_file($this->path())) {
            exit('找不到对应得模板文件');
        }
        
        $complieFile = $this->arrayConfig['complie'] . md5($file) . '.php'; //获得编译文件的路径
        
        $this->compileTool = new Compile($this->path(), $complieFile, $this->arrayConfig, $this->value);
        
        //判断是否存在编译文件或是否缓存编译文件或判断编译文件缓存时间
        if (!is_file($complieFile) || !$this->arrayConfig['is_complie_cache'] || (time() - filemtime($complieFile)) >= $this->arrayConfig['cache_complie_time']) {
            if (!is_dir($this->arrayConfig['complie'])) {
                mkdir($this->arrayConfig['complie']);
            }
            $this->compileTool->complie();
        } 
        
        return $complieFile;
    }
    
    
    
     /**
     * 编译并缓存静态模板
     * 
     * @access public
     * @param string $file 模板文件
     * @param string $cache_dir 缓存路径
     * @return void
     */
    public function fetch($file, $cache_dir = "") {
         $this->file = $file;
         if ($this->arrayConfig['cache_html'] ) {
             $cache_html_file = $cache_dir . $this->file . $this->arrayConfig['suffix_cache'];
             if(!is_file($cache_html_file) || (time() - filemtime($cache_html_file)) >= $this->arrayConfig['cache_html_time']){
                if ($cache_dir != "" && !is_dir($cache_dir)) {
                    mkdir($cache_dir);
                }
                ob_start();
                $this->show($file);
                $content = ob_get_contents();//取得php页面输出的全部内容
                ob_end_clean();
                $fp = fopen($cache_html_file, "w");
                fwrite($fp, $content);
                fclose($fp); 
                
             }
                include $cache_html_file;
         }else{
              $this->show($file);
         }
    }
    
    /**
     * 判断是否更新html模板文件
     * @param type $file
     * @return boolean 如果需要更新缓存返回true,不需要返回false;
     */
    public function update_html_data($file, $cache_dir = ""){
        
        $cache_html_file = $cache_dir . $file . $this->arrayConfig['suffix_cache'];
        
        if(!is_file($cache_html_file)){
            return true;
        }
        
        /**
         * 判断模板是否需要更新
         */
        if((time() - filemtime($cache_html_file)) >= $this->arrayConfig['cache_html_time']){//更新
            return true;
        }
        
        return false;
    }
    
    
    
   
    
   
    
    
    

    /**
     * 自动加载引入的类对象
     * 
     * 
     * @access public
     * @param string $class
     * @return  void
     */
    public function registerClass($class) {
        //print '[['. $class .']]';
        if ($class) {
            $file = dirname(__FILE__) . '/' . str_replace('\\', '/', $class);
            $file .= '.class.php';
            if (file_exists($file)) {
                include_once $file;
            }
        }
    }

}
