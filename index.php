<?php
include './Start/Start.class.php';



$start = new Start();
$start->assign("data", "Hello");
$start->assign("data2", " World!");
$start->assign("myArray", array('1', "2"=>array("3", "4")));
$start->show("show");



