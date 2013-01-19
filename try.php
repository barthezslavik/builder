<?php
require_once "config/initializers/ActiveRecord.php";

class Book extends ActiveRecord\Model { }

ActiveRecord\Config::initialize(function($cfg)
{
  $cfg->set_connections(array('development' => 'mysql://root:@127.0.0.1/builder_development'));
});

print_r(Book::first()->attributes());
