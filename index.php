<?php

require_once "config/initializers/ActiveRecord.php";
require_once "lib/Spyc.php";

$database = Spyc::YAMLLoad('config/database.yml');
$development = 'mysql://'.$database["development"]["username"].':'.$database["development"]["password"].'@'.$database["development"]["host"].'/'.$database["development"]["database"];

ActiveRecord\Config::initialize(function($cfg) use ($development) {
  $cfg->set_model_directory('app/models');
  $cfg->set_connections(array('development' => $development));
});

print'<pre>';
print_r(Book::first()->attributes());
print'</pre>';
