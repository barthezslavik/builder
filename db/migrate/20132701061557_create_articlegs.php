<?php
class CreateArticleg extends ActiveRecord\Migration {
  function up() {
    $this->create_table("articlegs", "name:string", "status:integer", "datetime");
  }

  function down() {
    $this->drop_table("articlegs");
  }
}

