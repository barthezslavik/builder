<?php 

ini_set('display_errors', "on");
error_reporting(E_ALL);

class Console {
  
  public $output_file = "build_output";
  public $command;

  function parse_params($post) {
    file_put_contents($this->output_file, json_encode($post)."<br>", FILE_APPEND);
    $this->command = $post["command"];
  }

  function run() {
    if ($this->command == "clear") 
      file_put_contents($this->output_file, "");
  }

  function render_css() {
    ?>
    <style>
      input { width:1200px; height:40px; font-size: 18px; font-family: Monaco} 
      #screen { width:1200px; height:400px; font-size: 13px; font-family: Verdana} 
    </style>
    <?
  }

  function render_js() {
    ?><script type="text/javascript">document.getElementById("console").focus();</script><?
  }

  function render_view() {
    $output = file_get_contents($this->output_file);
    ?><div id="screen"><?=$output ?></div>
      <form method="post">
      <input type="text" name="command" id="console">
      </form>
    <?
  }
}

$console = new Console();
$console->render_view();
$console->render_css();
$console->render_js();
$console->parse_params($_POST);
$console->run();

