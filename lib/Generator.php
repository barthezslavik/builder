<?php 

class Generator {
  function create_migration($params) {
    $this->lines = explode("\n",file_get_contents("console/templates/scaffold/migration.php"));
    $this->table = ActiveRecord\Inflector::instance()->tableize($params[1]);
    $this->model = ucfirst(ActiveRecord\Utils::singularize($this->table));
    $params = array_slice($params,2);
    $this->columns_with_types = '"'.join('", "', $params).'"';
    $this->replace_in_template("model","table","columns_with_types");
    $file_name = "db/migrate/".date('Ydmhis')."_create_{$this->table}.php";
    file_put_contents($file_name, $this->lines);
    chmod($file_name,0777);
  }

  function create_scaffold($params) {
     $this->create_migration($params);
     $this->create_model();
  }

  function create_model() {
    $this->fetch_file("scaffold/model.php");
    $this->replace_in_template("model");
    $this->write_file("app/models/{$this->model}.php");
  }

  function create_controller() {
    $this->fetch_file("scaffold/controller.php");
    $this->replace_in_template(" model");
    $this->write_file("app/controllers/{$this->model}Controller.php");
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
    $file_name = "app/models/{$this->model}.php";
    file_put_contents($file_name, $this->lines);
    chmod($file_name,0777);
  }

  private function fetch_file($file_name) {
    $this->lines = explode("\n", file_get_contents("console/templates/{$file_name}"));
  }
}
