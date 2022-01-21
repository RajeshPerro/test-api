<?php
/**
 * Created by PhpStorm.
 * User: rajesh
 * Date: 1/20/22
 * Time: 9:32 PM
 */

define("PROJECT_ROOT_PATH", __DIR__ . "/../");

// include main configuration file
require_once PROJECT_ROOT_PATH . "config/config.php";

// include main DB Connection file
require_once PROJECT_ROOT_PATH . "models/database.php";

require_once PROJECT_ROOT_PATH . "models/databaseOperations.php";

require_once PROJECT_ROOT_PATH . "models/model.php";
require_once PROJECT_ROOT_PATH . "models/userModel.php";

//controllers
require_once PROJECT_ROOT_PATH . "controllers/controller.php";
require_once PROJECT_ROOT_PATH . "controllers/userController.php";