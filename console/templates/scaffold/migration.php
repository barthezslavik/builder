<?php
class Create@model extends ActiveRecord\Migration {
  function up() {
    $this->create_table("@table", @columns_with_types, "datetime");
  }

  function down() {
    $this->drop_table("@table");
  }
}
