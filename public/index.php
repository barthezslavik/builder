<?php 

ini_set('display_errors', "on");
error_reporting(E_ALL)

function __autoload($class_name) {
  if (preg_match("/Model/", $class_name))
    require '../lib/Model.php';
  else if ($class_name == "Controller")
    require '../lib/Controller.php';
  else if (preg_match("/Controller/",$class_name))
    require '../app/controllers/'.$class_name . '.php';
  else {
    require '../app/models/'.$class_name . '.php';
  }
}

require "../lib/Support.php";
require "../lib/Route.php";
require "../config/Database.php";
require "../lib/Controller.php";
require "../lib/Form.php";

$controller = new Controller();
$controller->dispatch();
