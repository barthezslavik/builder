<?php 

ini_set('display_errors', "on");
error_reporting(E_ALL);


class Generator {

  function __construct() {

  }

  static function create_database() {
    $database = Spyc::YAMLLoad('config/database.yml');
    $development = 'mysql://'.$database["development"]["username"].':'.$database["development"]["password"].'@'.$database["development"]["host"].'/'.$database["development"]["database"];

    ActiveRecord\Config::initialize(function($cfg) use ($development) {
      $cfg->set_model_directory('app/models');
      $cfg->set_connections(array('development' => $development));
    });
    $connection = ActiveRecord\ConnectionManager::get_connection();
    $connection->query("CREATE DATABASE IF NOT EXISTS `".$database["development"]["database"]."` CHARACTER SET utf8 COLLATE utf8_general_ci");
    $connection->query("CREATE DATABASE IF NOT EXISTS `".$database["production"]["database"]."` CHARACTER SET utf8 COLLATE utf8_general_ci");
  }

  function create_scaffold() {
  
  }
}
