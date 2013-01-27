<?php
namespace ActiveRecord;
class SchemaMigration extends ActiveRecord\Model {}

class Migration {

  function __construct() {
    $this->connection = ConnectionManager::get_connection();
  }

  function create_table() {
    $data = func_get_args();
    $table_name = $data[0];
    $fields = array_slice($data,1);
    $query = "`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY"; 
    foreach($fields as $value) {
      $info = explode(":",$value);
      if ($info) {
        if(count($info)>1) {
          if($info[1] == "string") { $query .= ", `{$info[0]}` VARCHAR( 255 ) NOT NULL"; }
          if($info[1] == "text") { $query .= ", `{$info[0]}` TEXT NOT NULL"; }
          if($info[1] == "integer") { $query .= ", `{$info[0]}` INTEGER"; }
          if($info[1] == "boolean") { $query .= ", `{$info[0]}` TINYINT(1)"; }
        }
        if($info[0] == "datetime") { $query .= ", `created_at` DATETIME, `updated_at` DATETIME"; }
      }
    }

    $this->connection->query("CREATE TABLE IF NOT EXISTS `{$table_name}` ({$query})");
  }

  function drop_table() {
    $this->connection->query("DROP TABLE `samples`");
  }

  function run() {
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

}
