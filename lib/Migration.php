<?php
namespace ActiveRecord;

class Migration extends Singleton {

  function __construct() {
    $this->connection = ConnectionManager::get_connection();
  }

  function create_table() {
    
  }

  function drop_table() {
  }

}

  /*static function execute() {
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
  }*/

