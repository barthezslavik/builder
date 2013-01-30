<?php 
//=======================init section ========================================//
ini_set('display_errors', "on");
error_reporting(E_ALL);

require_once "config/initializers/ActiveRecord.php";
require_once "lib/Spyc.php";
require_once "lib/Generator.php";

$database = Spyc::YAMLLoad('config/database.yml');
$development = 'mysql://'.$database["development"]["username"].':'.$database["development"]["password"].'@'.$database["development"]["host"].'/'.$database["development"]["database"];

ActiveRecord\Config::initialize(function($cfg) use ($development) {
  $cfg->set_model_directory('app/models');
  $cfg->set_connections(array('development' => $development));
});

//====================== Console class ==========================================//
class Console {

  public $output_file = "console/build_output";
  public $command;

  function __construct() {
    $this->connection = ActiveRecord\ConnectionManager::get_connection();
    $this->generator = new Generator();
  }

  function parse_params($post) {

    if($post["command"] != "") 
    $history = file_get_contents($this->output_file);
    $history .= "<br>".$post["command"];
    $unique = array_unique(explode("<br>",$history));
    $updated_history = array_diff($unique,array(""));
    file_put_contents($this->output_file, implode("<br>",$updated_history));
    if($post["command"] == "clear")
      file_put_contents($this->output_file, "");
    $this->command = $post["command"];
  }

  function run() {
    $params = explode(" ",$this->command);
    if ($params[0] == "s" || $params[0] == "scaffold") {
      $this->generator->create_scaffold($params);
    }

    if ($params[0] == "m") {
      $migration = new ActiveRecord\Migration();
      $migration->run();  
    }

    if ($params[0] == "b") {
    }
  }
}

// ========================== Page generation ===================================//

$console = new Console();
if (count($_POST)>0) {
  $console->parse_params($_POST);
  $console->run();
}

$output = explode("\n",file_get_contents($console->output_file)); ?>

<style>
  #left { float: left; width: 660px; }
  input { width:650px; height:25px; font-size: 14px; font-family: Monaco; float: left; } 
  #screen { width:650px; height:400px; font-size: 12px; font-family: Verdana; background: #e3e3ea; float: left; } 
  #visual { width:650px; height:400px; font-size: 12px; font-family: Verdana; background: #e3e3ea; float: right; } 
</style>
<script type="text/javascript" src="vendor/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="console/console.js"></script>
<div id="left">
  <div id="screen"><? if($output) {foreach ($output as $key => $value) { ?><?=$value ?><? } } ?></div>
  <form method="post">
    <input type="text" name="command" id="console">
    <div id="autocomplete"></div>
  </form>
</div>
<div id="visual">1111111</div>
