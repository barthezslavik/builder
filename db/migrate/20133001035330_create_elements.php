<?php
class CreateElement extends ActiveRecord\Migration {
  function up() {
    $this->create_table("elements", "name:string", "content:text", "type_id:integer", "checked:boolean", "datetime");
  }

  function down() {
    $this->drop_table("elements");
  }
}

