<?php

define("PROJECT_ROOT_PATH", __DIR__ . "/../");

// include main configuration file
require_once PROJECT_ROOT_PATH . "config/config.php";

// include main configuration file
require_once PROJECT_ROOT_PATH . "utility/tools.php";



// include main DB Connection file
require_once PROJECT_ROOT_PATH . "models/database.php";

require_once PROJECT_ROOT_PATH . "models/databaseOperations.php";

require_once PROJECT_ROOT_PATH . "models/model.php";
require_once PROJECT_ROOT_PATH . "models/userModel.php";
require_once PROJECT_ROOT_PATH . "models/tripsModel.php";
require_once PROJECT_ROOT_PATH . "models/reservationsModel.php";

// services
require_once PROJECT_ROOT_PATH . "services/reservationServices.php";

//controllers
require_once PROJECT_ROOT_PATH . "controllers/controller.php";
require_once PROJECT_ROOT_PATH . "controllers/userController.php";
require_once PROJECT_ROOT_PATH . "controllers/tripsController.php";
require_once PROJECT_ROOT_PATH . "controllers/reservationsController.php";

//include router
include PROJECT_ROOT_PATH. "router/route.php";