<?php
class CreateTest extends ActiveRecord\Migration {
  function up() {
    $this->create_table("tests", "name:string", "content:text", "type_id:integer", "checked:boolean", "datetime");
  }

  function down() {
    $this->drop_table("tests");
  }
}

