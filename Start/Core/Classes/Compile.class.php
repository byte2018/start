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
    private $arrPatten = array(); //定制正则表达式匹配数组
    private $arrPHP = array(); //定制匹配后的编译结果

    public function __construct($template, $comfile, $arrayConfig) {
        $this->template = $template;
        $this->comfile = $comfile;
        $this->arrayConfig = $arrayConfig;

        $this->arrPatten = array(
            "#{$arrayConfig['left']}\s*\\$([a-zA-Z_][a-zA-Z0-9_]*)\s*{$arrayConfig['right']}#",
            "#{$arrayConfig['left']}\s*(foreach)\s*(from=)\\$([a-zA-Z_][a-zA-Z0-9_]*)\s*(item=)([a-zA-Z_][a-zA-Z0-9_]*)\s*{$arrayConfig['right']}#",
            "#{$arrayConfig['left']}\s*(foreach)(.*)({$arrayConfig['right']})(.*){$arrayConfig['left']}\s*\\$([a-zA-Z_][a-zA-Z0-9_]*)\s*{$arrayConfig['right']}#",        
            "#{$arrayConfig['left']}\s*(\/foreach)\s*{$arrayConfig['right']}#"
        );

        $this->arrPHP = array(
            "<?php echo \$this->value['\\1']; ?>",
            "<?php foreach ((array) \$this->value['\\3'] as \$k => \$\\5){ ?>",
             "<?php echo \$\\1; ?>",
             "<?php } ?>"
        );

        $this->content = file_get_contents($template);
    }

    /**
     * 编译入口
     * 
     * @access public
     * @return void
     */
    public function complie() {
        $this->c_var();
        file_put_contents($this->comfile, $this->content);
    }

    /**
     * 简单参数编译
     */
    public function c_var() {
        $this->content = preg_replace($this->arrPatten, $this->arrPHP, $this->content);
    }
    

}
