<?php
namespace ActiveRecord;

class Migration extends Singleton {

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
        if($info[1] == "string") { $query .= ", `{$info[0]}` VARCHAR( 255 ) NOT NULL"; }
        if($info[1] == "text") { $query .= ", `{$info[0]}` TEXT NOT NULL"; }
        if($info[1] == "integer") { $query .= ", `{$info[0]}` INTEGER"; }
        if($info[1] == "boolean") { $query .= ", `{$info[0]}` TINYINT(1)"; }
        if($info[1] == "datetime") { $query .= ", `created_at` DATETIME, `updated_at` DATETIME"; }
      }
    }

    $this->connection->query("CREATE TABLE IF NOT EXISTS `{$table_name}` ({$query})");
  }

  function drop_table() {
    $this->connection->query("DROP TABLE `samples`");
  }

}
