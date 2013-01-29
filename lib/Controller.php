<?php

class Controller {
  function dispatch() {
    require "config/routes.php";
    $this->route = $router->dispatch();
    if (!$this->route)
      die("No route match");

    $controller_name = ucfirst($_REQUEST["controller"])."Controller";
    $action_name = $_REQUEST["action"];
    require "app/controllers/{$controller_name}.php";
    $controller = new $controller_name;
    $controller->params = $this->route["params"];
    //if (isset($_POST["id"])) $controller->params["id"] = $_POST["id"];
    $controller->$action_name();
    $controller->render_layout();
  }

  function render_layout() {
    require "app/views/layout.html";
  }

  function render($partial) {
    require "app/views/{$_REQUEST["controller"]}/_".$partial.".html";
  }

  function redirect_to($action) {
    header("Location: {$_SERVER["HTTP_ORIGIN"]}/articles");
    $_REQUEST["action"] = $action;
    $this->{$action};
  }
}
