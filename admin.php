<?php
define("DS",DIRECTORY_SEPARATOR);
define("ROOT_PATH",getcwd().DS);
define("APP_PATH",ROOT_PATH."Admin".DS);
define("Public_PATH",ROOT_PATH."Public".DS."Admin".DS);

require_once(ROOT_PATH."Frame".DS."Frame.class.php");
Frame\Frame::run();
