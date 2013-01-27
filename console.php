<?php 

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

class SchemaMigration extends ActiveRecord\Model {}

class Console {

  public $output_file = "console/build_output";
  public $command;

  function __construct() {
    $this->connection = ActiveRecord\ConnectionManager::get_connection();
    $this->generator = new Generator();
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
    if ($params[0] == "s" || $params[0] == "scaffold") {
      $this->generator->create_scaffold($params);
    }

    if ($params[0] == "m") {
      $files = scandir("db/migrate");
      $files = array_slice($files, 2);
      foreach($files as $file) {
        $version = explode("_", $file)[0];
        $schema_migration = SchemaMigration::find_by_version($version);
        if ($schema_migration == NULL) {
          $classes = get_declared_classes();
          require "db/migrate/{$file}";
          $diff = array_diff(get_declared_classes(), $classes);
          $class = reset($diff);
          $migration_class = new $class;
          $migration_class->up();
          $schema_migration = new SchemaMigration(array("version" => $version));
          $schema_migration->save();
        }
      }
    }

    if ($params[0] == "b") {
    }
  }
}

$console = new Console();
if (count($_POST)>0) {
  $console->parse_params($_POST);
  $console->run();
}

$output = explode("\n",file_get_contents($console->output_file)); ?>

<style>
  input { width:650px; height:25px; font-size: 14px; font-family: Monaco } 
  #screen { width:650px; height:400px; font-size: 12px; font-family: Verdana; background: #e3e3ea; } 
</style>
<script type="text/javascript" src="vendor/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="console/console.js"></script>
<div id="screen"><? if($output) {foreach ($output as $key => $value) { ?><?=$value ?><? } } ?></div>
<form method="post">
  <input type="text" name="command" id="console">
  <div id="autocomplete"></div>
</form>
