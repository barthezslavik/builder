<?php
class CreateStars extends ActiveRecord\Migration {
  function up() {
    $this->create_table("stars", "status:boolean", "datetime");
  }

  function down() {
    $this->drop_table("stars");
  }
}

