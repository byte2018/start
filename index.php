<?php
include './StartExt.class.php';



$start = new StartExt();
$dir = "./cache/";
$file = "show";

if($start->update_html_data($file, $dir)){//判断文件是否需要更新
    $start->assign("data", "Hello");
    $start->assign("data2", " World!");
    $start->assign("isflag", 2);
    $start->assign("myArray", array('1', "2"=>array("3", "4")));
    //$start->show("show");
//    echo "sdfsdaf";
    $start->fetch("show", $dir);
}else{
    $url = "http://localhost/starttemplate/{$dir}{$file}.html";
    echo "<script type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}








