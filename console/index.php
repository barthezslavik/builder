<?php 

ini_set('display_errors', "on");
error_reporting(E_ALL);

class Console {
  function parse_params($post) {
  }

  function render_css() {
    
  }

  function render_view() {
    <<<INPUT
    <input type="text" id="$id" name="$name" size="$size" placeholder="$placeholder" value="$value">\n
    INPUT;
  }
}

$console = new Console();
$console->render_view();
$console->parse_params($_POST);

