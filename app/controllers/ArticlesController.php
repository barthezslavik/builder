<?php 

class ArticlesController extends Controller {

  function index() {
    $this->articles = Article::all();
  }

  function show() {
    $this->article = Article::find($this->params["id"]);
  }

  function edit() {
    $this->article = Article::find($this->params["id"]);
  }

  function destroy() {
    if (Article::find($this->params["id"])->delete())
      $this->redirect_to("index");
  }

  function create() {
    $article = new Article($this->params["article"]);
    if ($article->save())
      $this->redirect_to("index");
  }

  function update() {
    if (Article::find($this->params["id"])->update_attributes($this->params["article"]))
      $this->redirect_to("index");
  }

  function add() {
    $this->article = new Article;
  }
 
}

