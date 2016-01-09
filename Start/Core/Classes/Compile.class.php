<?php

/**
 * Start Template
 * 永久开源免费
 */
/**
 * 模板编译类
 *
 * @author wangzhen
 */

namespace Core\Classes;

class Compile {

    private $arrayConfig = array();
    private $template; //需要编译的文件
    private $comfile; //编译后的文件
    private $value = array();
    private $content; //需要替换的文本
  

    public function __construct($template, $comfile, $arrayConfig, $value) {
        $this->template = $template;
        $this->comfile = $comfile;
        $this->arrayConfig = $arrayConfig;
        $this->value = $value;
       

        $this->content = file_get_contents($template);
    }

    /**
     * 编译入口
     * 
     * @access public
     * @return void
     */
    public function complie() {
        $this->c_foreach();
        $this->c_var();
        file_put_contents($this->comfile, $this->content);
    }

    /**
     * 简单参数编译
     */
    public function c_var() {
        $patten_str = "#{$this->arrayConfig['left']}\s*\\$([a-zA-Z_][a-zA-Z0-9_]*)([a-zA-Z0-9_(\\[(a-zA-Z0-9_\"\')\\]|\\.|\\-\\>)]*)\s*{$this->arrayConfig['right']}#";
        $php_str = "<?php echo \$\\1\\2; ?>";
        $this->content = preg_replace($patten_str, $php_str, $this->content);
    }
    
    /**
     * 迭代参数编译
     */
    public function c_foreach(){
        $patten_foreach_str =  "#{$this->arrayConfig['left']}\s*(foreach)\s*(from=)\\$([a-zA-Z_][a-zA-Z0-9_]*)\s*(item=)([a-zA-Z_][a-zA-Z0-9_]*)\s*{$this->arrayConfig['right']}#";
        
        preg_match_all($patten_foreach_str, $this->content, $matches, PREG_SET_ORDER);
        
         $arrPatten = array(
            "#{$this->arrayConfig['left']}\s*(foreach)\s*(from=)\\$([a-zA-Z_][a-zA-Z0-9_]*)\s*(item=)([a-zA-Z_][a-zA-Z0-9_]*)\s*{$this->arrayConfig['right']}#",
            "#{$this->arrayConfig['left']}\s*(\/foreach)\s*{$this->arrayConfig['right']}#"
        );

        $arrPHP = array(
            "<?php foreach ((array) \$\\3 as \$k => \$\\5){ ?>",
             "<?php } ?>"
        );
        
        foreach ($matches as $val) {
            $patten_str = "#{$this->arrayConfig['left']}\s*\\$({$val[5]}(\\[|\\.|->))(.*)\s*{$this->arrayConfig['right']}#";
            $php_str = "<?php echo \$\\1\\3; ?>";
            $this->content = preg_replace($patten_str, $php_str, $this->content);
        }    
         
        $this->content = preg_replace($arrPatten, $arrPHP, $this->content); 
    }
    
    /**
     * if语句编译
     */
    public function c_if(){
        
        
        
    }
    

}
