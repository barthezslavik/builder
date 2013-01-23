<?php
namespace ActiveRecord;
use Closure;

class Migration extends Singleton {
  public static function create_table(Closure $initializer) {
    $initializer(parent::instance());
  }

  function table($table) {
    $this->table = $table;
    $this->connection = ConnectionManager::get_connection();
  }

  function string($name) {
    $this->fileds[] = "string".$name;
  }

  function text($name) {
    $this->text = $name;
  }

  function datetime() {
  print'<pre>';
  print_r($this);
  print'</pre>';
  die("+++");
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

/*
class Config extends Singleton
{

        private $default_connection = 'development';

        private $connections = array();

        private $model_directory;

        private $logging = false;

        private $logger;

        private $date_format = \DateTime::ISO8601;

        public static function create_table(Closure $initializer)
        {


          $initializer(parent::instance());

        }


        public function set_connections($connections, $default_connection=null)
        {
                if (!is_array($connections))
                        throw new ConfigException("Connections must be an array");

                if ($default_connection)
                        $this->set_default_connection($default_connection);

                $this->connections = $connections;

};*/
