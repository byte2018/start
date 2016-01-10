<?php

/**
 * Start 
 * 永久开源免费
 */

/**
 * 模型类,存储着foreach或其他的一些隐形属性
 *
 * @author wangzhen
 */

namespace Core\Model;
class StartModel {

    private $index;

    public function __construct($index) {
        $this->index = $index;
    }

    
    public function __set($name, $value) {
        $this->$name = $value;
    }


    public function __get($name) {
        return $this->$name;
    }

}
