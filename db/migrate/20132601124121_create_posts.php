<?php
class CreatePosts extends ActiveRecord\Migration {
  function up() {
    $this->create_table("posts", "name:string", "content:text", "datetime");
  }

  function down() {
    $this->drop_table("posts");
  }
}

