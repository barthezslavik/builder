<?php 

require "Support.php";

class Generator {
  function init($params) {
    $this->plural = $this->table = Support::pluralize($params[1]);
    $this->model = ucfirst(Support::singularize($this->table));
    $this->singular = Support::singularize($this->table);
    $this->controller = ucfirst($this->table);
    $this->params = array_slice($params,2);
  }

  function create_migration() {
    $this->fetch_file("scaffold/migration.php");
    $this->columns_with_types = '"'.join('", "', $this->params).'"';
    $this->replace_in_template("model","table","columns_with_types");
    $this->write_file("db/migrate/".date('Ydmhis')."_create_{$this->table}.php");
  }

  function create_scaffold($params) {
     $this->init($params);
     $this->create_migration();
     $this->create_model();
     $this->create_controller();
  }

  function create_model() {
    $this->fetch_file("scaffold/model.php");
    $this->replace_in_template("model");
    $this->write_file("app/models/{$this->model}.php");
  }

  function create_controller() {
    $this->fetch_file("scaffold/controller.php");
    $this->replace_in_template("controller", "model", "plural", "singular");
    $this->write_file("app/controllers/{$this->controller}Controller.php");
  }

  function models_structure() {}

  private function replace_in_template() {
    $args = func_get_args();
    foreach($this->lines as $num => $line) {
      foreach($args as $name) {
        @$this->lines[$num] = str_replace("@".$name, $this->${name}, $this->lines[$num]);
      }
      $this->lines[$num] .= "\n"; 
    }
  }

  private function write_file($file_name) {
    file_put_contents($file_name, $this->lines);
    chmod($file_name,0777);
  }

  private function fetch_file($file_name) {
    $this->lines = explode("\n", file_get_contents("console/templates/{$file_name}"));
  }
}
