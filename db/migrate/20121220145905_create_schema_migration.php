<?php
class CreateSchemaMigration extends ActiveRecord\Migration {
  function up() {
    $this->create_table("schema_migrations", "version:string");
  }

  function down() {
    $this->drop_table("schema_migrations");
  }
}
