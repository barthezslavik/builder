<?php 

require "Support.php";

class Generator {
  function init($params) {
    $this->plural = $this->table = Support::pluralize($params[1]);
    $this->model = ucfirst(Support::singularize($this->table));
    $this->singular = Support::singularize($this->table);
    $this->controller = ucfirst($this->table);
    $this->params = array_slice($params,2);
    $this->routes = "config/routes.php";
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
    $this->create_views();
    $this->create_route();
    $migration = new ActiveRecord\Migration();
    $migration->run(); 
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

  function create_views() {
    $this->create_folder("app/views/{$this->plural}");

    $this->fetch_file("scaffold/views/add.html");
    $this->replace_in_template("model", "plural", "singular");
    $this->write_file("app/views/{$this->plural}/add.html");

    $this->fetch_file("scaffold/views/edit.html");
    $this->replace_in_template("controller", "model", "plural", "singular");
    $this->write_file("app/views/{$this->plural}/edit.html");

    $this->generate_form();

    $this->fetch_file("scaffold/views/index.html");
    $this->replace_in_template("controller", "model", "plural", "singular");
    $this->write_file("app/views/{$this->plural}/index.html");

    $this->fetch_file("scaffold/views/show.html");
    $this->replace_in_template("controller", "model", "plural", "singular");
    $this->write_file("app/views/{$this->plural}/show.html");
  }

  private function generate_form() {

    $this->fields = [];
    foreach($this->params as $item) {
      $this->name = explode(":",$item)[0];
      $this->type = explode(":",$item)[1];
      $this->fetch_file("scaffold/views/form/{$this->type}.html");
      $this->lines = array_diff($this->lines, array(""));
      $this->replace_in_template("name");
      $this->fields[] = $this->lines[0];
    }
    $this->fetch_file("scaffold/views/_form.html");
    $this->fields = implode("<br><br>",$this->fields);
    $this->lines[1] = $this->fields;
    $this->lines = array_diff($this->lines, array(""));
    $this->replace_in_template("singular");
    $this->write_file("app/views/{$this->plural}/_form.html");
  }

  function create_route() {
    $this->add_route('$router->resources("'.$this->plural.'");');
  }

  function delete_scaffold($params) {
    $this->init($params);
    unlink("app/controllers/{$this->controller}Controller.php");
    unlink("app/views/{$this->plural}/_form.html");
    unlink("app/views/{$this->plural}/add.html");
    unlink("app/views/{$this->plural}/edit.html");
    unlink("app/views/{$this->plural}/index.html");
    unlink("app/views/{$this->plural}/show.html");
    unlink("app/models/{$this->model}.php");
    rmdir("app/views/{$this->plural}");
    $this->remove_route('$router->resources("'.$this->plural.'");');
    $this->remove_migration("create_{$this->plural}");
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

  private function add_route($route) {
    $lines = explode("\n",file_get_contents($this->routes));
    if (!in_array($route, $lines)) {
      $lines[] = $route."\n";
      $content = array_diff($lines,array(""));
      $content = implode("\n",$content);
      file_put_contents($this->routes, $content);
    }
  }

  private function remove_route($route) {
    $lines = explode("\n",file_get_contents($this->routes));
    foreach($lines as $key => $value) {
      if($value == $route) {
        unset($lines[$key]);
      }
    }
    $content = array_diff($lines,array(""));
    $content = implode("\n",$content);
    file_put_contents($this->routes, $content);
  }

  private function remove_migration($name) {
    $files = scandir("db/migrate");
    $files = array_slice($files, 2);
    foreach($files as $file) {
      if (preg_match("/{$name}/", $file))
        unlink("db/migrate/{$file}");
    }
  }

  private function write_file($file_name) {
    file_put_contents($file_name, $this->lines);
    chmod($file_name, 0777);
  }

  private function create_folder($folder_name) {
    @mkdir($folder_name, 0777);
  }

  private function fetch_file($file_name) {
    $this->lines = explode("\n", file_get_contents("console/templates/{$file_name}"));
  }
}
