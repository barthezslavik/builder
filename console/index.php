<?php 

ini_set('display_errors', "on");
error_reporting(E_ALL);

class Console {

  public $output_file = "build_output";
  public $params;

  function parse_params($post) {

    if($post["command"] != "") 
      file_put_contents($this->output_file, $post["command"]."<br>", FILE_APPEND);
    if($post["command"] == "clear")
      file_put_contents($this->output_file, "");
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
    $(document).ready(function() {
      variants = [
        "g scaffold", "g model", "g controller",
      ]
      $("#console").focus();
      $("#console").keyup(function(e) {
        console.log(e.keyCode);
        if (e.keyCode == 40) {
          variants = $("#autocomplete").find("div");
          console.log(variants);
        } else {
          var current_value = $("#console").val();
          $.each(variants, function(index, value) {
            //console.log(current_value, value);
            if (value.match(current_value)) {
              console.log(value);
            }
          });
        }
      });
    });
    </script><?
  }

  function render_form() {
    $output = file_get_contents($this->output_file);
    ?>
      <form method="post">
      <input type="text" name="command" id="console">
      <div id="autocomplete"></div>
      </form>
  <?
  }

  function render_output() {
    $output = explode("\n",file_get_contents($this->output_file)); 
?>
    <div id="screen">
    <? if($output) {
      foreach ($output as $key => $value) { ?>
      <?=$value ?>
    <? } } ?>
    </div>
    <?
  }
}

$console = new Console();
if (count($_POST)>0) {
  $console->parse_params($_POST);
  $console->run();
  $console->render_output();
}
$console->render_form();
$console->render_css();
$console->render_js();
