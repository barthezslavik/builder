<?php 

ini_set('display_errors', "on");
error_reporting(E_ALL);

class Console {

  public $output_file = "build_output";
  public $params;

  function parse_params($post) {
    file_put_contents($this->output_file, json_encode($post)."\n", FILE_APPEND);
    $this->params = $post;
  }

  function run() {
  }

  function render_css() {
?>
    <style>
      input { width:1200px; height:40px; font-size: 18px; font-family: Monaco} 
      #screen { width:1200px; height:400px; font-size: 14px; font-family: Verdana} 
    </style>
<?
  }

  function render_js() {
?>
    <script type="text/javascript" src="../vendor/jquery-1.9.0.min.js"></script>
    <script type="text/javascript">
    document.getElementById("console").focus();
    </script><?
  }

  function render_form() {
    $output = file_get_contents($this->output_file);
    ?><div id="screen"><?=$output ?></div>
      <form method="post">
      <input type="text" name="command" id="console">
      </form>
<?
  }

  function render_output() {
    $output = file_get_contents($this->output_file);
    if ($output) { ?>
      <script type="text/javascript">
      $("#screen").text('<?=$output?>');
      </script>
    <?
    }
  }
}

$console = new Console();
$console->render_form();
$console->render_css();
$console->render_js();
$console->parse_params($_POST);
if (count($_POST)>0) {
  $console->run();
  $console->render_output();
}
