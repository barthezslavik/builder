<?php
class CreateArticles extends ActiveRecord\Migration {
  function up() {
    $this->create_table("articles", "name:string", "status:integer", "datetime");
  }

  function down() {
    $this->drop_table("articles");
  }
}

