<?php 

class Generator {
  function create_migration($params) {
    $this->lines = explode("\n",file_get_contents("console/templates/scaffold/migration.php"));
    $this->table = ActiveRecord\Inflector::instance()->tableize($params[1]);
    $this->model = ucfirst(ActiveRecord\Utils::singularize($this->table));
    $params = array_slice($params,2);
    $this->columns_with_types = '"'.join('", "', $params).'"';
    $this->replace_template("model","table","columns_with_types");
    $file_name = "db/migrate/".date('Ydmhis')."_create_{$this->table}.php";
    file_put_contents($file_name, $this->lines);
    chmod($file_name,0777);
    print "create migration ".$file_name."\n";
  }

  function create_scaffold($params) {
     $this->create_migration($params);
     $this->create_model();
  }

  function create_model() {
    $this->lines = explode("\n",file_get_contents("console/templates/scaffold/model.php"));
    $this->replace_template("model");
    $file_name = "app/models/{$this->model}.php";
    file_put_contents($file_name, $this->lines);
    chmod($file_name,0777);
    print "create model ".$file_name."\n";
  }

  private function replace_template() {
    $args = func_get_args();
    foreach($this->lines as $num => $line) {
      foreach($args as $name) {
        @$this->lines[$num] = str_replace("@".$name, $this->${name}, $this->lines[$num]);
      }
      $this->lines[$num] .= "\n"; 
    }
  }
}
