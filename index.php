<?php
//定义常量
define("DS",DIRECTORY_SEPARATOR);
define("ROOT_PATH",getcwd().DS);
define("APP_PATH",ROOT_PATH."Home".DS);
define("PUBLIC_PATH",ROOT_PATH."Public".DS."Home".DS);

//载入初始类文件
require_once(ROOT_PATH."Frame".DS."Frame.class.php");
Frame\Frame::run();
// require_once("./Home/View/index.html");

