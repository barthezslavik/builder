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
    $this->generator = new Generator();
    $this->models = array("book, schema_migration");
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
      require "db/migrate/20121220145905_create_schema_migration.php";
      $create_schema = new CreateSchemaMigration();
      $create_schema->up();
      $schema_migration = new SchemaMigration(array('version' => 'Tito'));
      $schema_migration->save(); 
    }

    if ($params[0] == "b") {
    }
  }

  function render_css() { ?>
    <style>
      input { width:650px; height:25px; font-size: 14px; font-family: Monaco} 
      #screen { width:650px; height:400px; font-size: 12px; font-family: Verdana; background: #e3e3ea;} 
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

function render_structure() {
  print_r(json_encode($this->models));
}

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
$console->render_structure();
$console->render_css();
$console->render_js();
