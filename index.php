<?php
ini_set('display_errors', "on");
error_reporting(E_ALL);

require_once "config/initializers/ActiveRecord.php";
require_once "lib/Spyc.php";
require_once "lib/Support.php";
require_once "lib/Controller.php";
require_once "lib/Route.php";
require_once "lib/Form.php";

$database = Spyc::YAMLLoad('config/database.yml');
$development = 'mysql://'.$database["development"]["username"].':'.$database["development"]["password"].'@'.$database["development"]["host"].'/'.$database["development"]["database"];

ActiveRecord\Config::initialize(function($cfg) use ($development) {
  $cfg->set_model_directory('app/models');
  $cfg->set_connections(array('development' => $development));
});

$controller = new Controller();
$controller->dispatch();
