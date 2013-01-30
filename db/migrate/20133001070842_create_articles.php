<?php
class CreateArticle extends ActiveRecord\Migration {
  function up() {
    $this->create_table("articles", "a:string", "b:integer", "c:text", "datetime");
  }

  function down() {
    $this->drop_table("articles");
  }
}

