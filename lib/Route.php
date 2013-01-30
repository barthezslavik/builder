<?php

class Router {

  function resources($model) {
    $this->add_route("GET",  $model, "/{$model}",            "index");
    $this->add_route("POST", $model, "/{$model}",            "create");
    $this->add_route("GET",  $model, "/{$model}/add",        "add");
    $this->add_route("GET",  $model, "/{$model}/:id/edit",   "edit");
    $this->add_route("GET",  $model, "/{$model}/:id",        "show");
    $this->add_route("PUT",  $model, "/{$model}/:id",        "update");
    $this->add_route("GET",  $model, "/{$model}/:id/delete", "destroy");
  }

  function add_route($method, $model, $url, $action) {
    $route["method"] = $method;
    $route["model"] = $model;
    $route["url"] = $url;
    $route["action"] = $action;
    $this->routes[] = $route;
  }

  function match($model, $execute) {
    $run = explode("#",$execute);
    $this->add_route("GET", $run[0], "/{$run[0]}", $run[1]);
  }

  function dispatch() {
    $method = (isset($_POST['_method']) && ($_method = strtoupper($_POST['_method']))) ? $_method : $_SERVER['REQUEST_METHOD'];
    foreach($this->routes as $route) {
      if ($method != $route["method"]) continue;
      $request = str_replace(".json", "", $_SERVER["REQUEST_URI"]);
      if (!preg_match("@^".preg_replace("/:(\w+)/", "([\w-]+)", $route["url"])."*$@i", $request, $matches)) continue;
      $params = array();
      if (preg_match_all("/:([\w-]+)/", $route["url"], $argument_keys)) {
        $argument_keys = $argument_keys[1];
        foreach ($argument_keys as $key => $name) {
          if (isset($matches[$key + 1]))
            $params[$name] = $matches[$key + 1];
        }
      }

      $route["params"] = $params;
      $_REQUEST["controller"] = $route["model"];
      $_REQUEST["action"] = $route["action"];
      if($_SERVER['REQUEST_METHOD'] == "POST") {
        foreach($_POST as $key => $value) 
          $route["params"][$key] = $value;
      }
      return $route;
    }
    return false;
  }

}
