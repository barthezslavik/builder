<?php 

ini_set('display_errors', "on");
error_reporting(E_ALL);

class Console {
  function parse_params($post) {
  }

  function render_css() {
    ?><style>input { width:1200px; height:40px; font-size: 18px; font-family: Monaco}</style><?
  }

  function render_js() {
    ?><script type="text/javascript">document.getElementById("console").focus();</script><?
  }

  function render_view() {
    ?><input type="text" name="command" id="console"><?
  }
}

$console = new Console();
$console->render_view();
$console->render_css();
$console->render_js();
$console->parse_params($_POST);

