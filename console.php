<?php 

ini_set('display_errors', "on");
error_reporting(E_ALL);

require_once "config/initializers/ActiveRecord.php";
require_once "lib/Spyc.php";
require_once "console/generator.php";

$database = Spyc::YAMLLoad('config/database.yml');
$development = 'mysql://'.$database["development"]["username"].':'.$database["development"]["password"].'@'.$database["development"]["host"].'/'.$database["development"]["database"];

ActiveRecord\Config::initialize(function($cfg) use ($development) {
  $cfg->set_model_directory('app/models');
  $cfg->set_connections(array('development' => $development));
});

class Console {

  public $output_file = "console/build_output";
  public $command;

  function __construct() {
    $this->connection = ActiveRecord\ConnectionManager::get_connection();
  }

  function parse_params($post) {

    if($post["command"] != "") 
      file_put_contents($this->output_file, $post["command"]."<br>", FILE_APPEND);
    if($post["command"] == "clear")
      file_put_contents($this->output_file, "");
    $this->command = $post["command"];
  }

  function run() {
    $params = explode(" ",$this->command);
    if ($params[0] == "scaffold") {
      
      $table_name = ActiveRecord\Inflector::instance()->tableize($params[1]);
      $fields = array_slice($params, 2);

      require "db/migrate/20121220145904_create_samples.php";
      $migration = new CreateSamples();
      $migration->up();

      /*
      $columns = "`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY";
      
      foreach($fields as $value) {
        $info = explode(":",$value);
        if ($info) {
          if($info[1] == "string") { $columns .= ", `{$info[0]}` VARCHAR( 255 ) NOT NULL"; }
          if($info[1] == "text") { $columns .= ", `{$info[0]}` TEXT NOT NULL"; }
          if($info[1] == "integer") { $columns .= ", `{$info[0]}` INTEGER"; }
          if($info[1] == "boolean") { $columns .= ", `{$info[0]}` TINYINT(1)"; }
        }
      }

      $this->connection->query(
        "CREATE TABLE IF NOT EXISTS `{$table_name}` ({$columns})
        ");
       */

    }
  }

  function render_css() { ?>
    <style>
      input { width:1200px; height:40px; font-size: 18px; font-family: Monaco} 
      #screen { width:1200px; height:400px; font-size: 14px; font-family: Verdana} 
    </style>
<? }

function render_js() { ?>
    <script type="text/javascript" src="vendor/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="console/console.js"></script>
<? }

function render_form() {
  $output = file_get_contents($this->output_file); ?>
      <form method="post">
      <input type="text" name="command" id="console">
      <div id="autocomplete"></div>
      </form>
<? }

function render_output() {
  $output = explode("\n",file_get_contents($this->output_file));?>
    <div id="screen"><? if($output) {foreach ($output as $key => $value) { ?><?=$value ?><? } } ?></div>
<? }
}

$console = new Console();
if (count($_POST)>0) {
  $console->parse_params($_POST);
  $console->run();
}
$console->render_output();
$console->render_form();
$console->render_css();
$console->render_js();