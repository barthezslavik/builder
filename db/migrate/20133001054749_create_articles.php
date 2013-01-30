<?php
class CreateArticle extends ActiveRecord\Migration {
  function up() {
    $this->create_table("articles", "a:string", "datetime");
  }

  function down() {
    $this->drop_table("articles");
  }
}

