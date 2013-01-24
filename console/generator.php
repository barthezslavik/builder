<?php 

class Generator {
  function create_migration($params) {
    $lines = explode("\n",file_get_contents("console/templates/scaffold/migration.php"));
    $table = ActiveRecord\Inflector::instance()->tableize($params[1]);
    $model = ucfirst($table);
    $params = array_slice($params,2);
    $columns_with_types = '"'.join('", "', $params).'"';
    foreach($lines as $num => $line) {
      $lines[$num] = str_replace("{model}",$model, $lines[$num]);
      $lines[$num] = str_replace("{table}",$table, $lines[$num]);
      $lines[$num] = str_replace("{columns_with_types}", $columns_with_types, $lines[$num]);
      $lines[$num] .= "\n"; 
    } 
    $file_name = "db/migrate/".date('Ydmhis')."_create_{$table}.php";
    file_put_contents($file_name, $lines);
    chmod($file_name,0777);
    print "create migration ".$file_name."\n";
  }

  function create_scaffold($params) {
     $this->create_migration($params);
  }
}
