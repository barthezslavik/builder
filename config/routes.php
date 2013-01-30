<?php
$router = new Router();
$router->resources("comments");
$router->resources("posts");
$router->match("/console","console#main");
$router->resources("articles");
