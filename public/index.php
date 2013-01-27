<?php 

ini_set('display_errors', "on");
error_reporting(E_ALL);

require "../lib/Route.php";
require "../lib/Controller.php";
require "../lib/Form.php";

$controller = new Controller();
$controller->dispatch();
