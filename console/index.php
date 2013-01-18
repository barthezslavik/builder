<?php 

ini_set('display_errors', "on");
error_reporting(E_ALL);

class Console {
  function parse_params($post) {
  }

  function render_css() {
    ?><style>input {width:300px;}</style><?
  }

  function render_view() {
    ?><input type="text" name="command"><?
  }
}

$console = new Console();
$console->render_view();
$console->render_css();
$console->parse_params($_POST);

