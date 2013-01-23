<?php
class CreateSamples {
  static function up() {
    ActiveRecord\Migration::create_table(function($t) {
      $t->table("samples");
      $t->string("name");
      $t->text("description");
      $t->datetime();
    });
  }

  static function down() {
    ActiveRecord\Migration::drop_table("samples");
  }
}
