<?php
class CreateSamples extends ActiveRecord\Migration {
  function up() {
    $this->create_table("samples", "string:name", "text:description", "datetime");
  }

  function down() {
    $this->drop_table("samples");
  }
}
