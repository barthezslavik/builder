<?php
class CreateArticle extends ActiveRecord\Migration {
  function up() {
    $this->create_table("articles", "name:string", "content:text", "type_id:integer", "checked:boolean", "datetime");
  }

  function down() {
    $this->drop_table("articles");
  }
}

