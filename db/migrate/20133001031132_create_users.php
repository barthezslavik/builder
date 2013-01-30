<?php
class CreateUser extends ActiveRecord\Migration {
  function up() {
    $this->create_table("users", "name:string", "datetime");
  }

  function down() {
    $this->drop_table("users");
  }
}

