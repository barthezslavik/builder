<?php 

class ArticlesController extends Controller {

  function index() {
    $this->articles = Article::all();
  }

  function show() {
    $this->article = Article::find($this->params["id"]);
  }

  function edit() {
    //${model} = new {capital};
    //$this->{model} = ${model}->find($this->params["id"]);
  }

  function destroy() {
    //${model} = new {capital};
    //$this->{model} = ${model}->find($this->params["id"]);
    //if ($this->{model}->destroy()) 
    //  $this->redirect_to("index");
  }

  function create() {
    $article = new Article($this->params["article"]);
    if ($article->save())
      $this->redirect_to("index");
  }

  function update() {
    //${model} = new {capital};
    //$this->{model} = ${model}->find($this->params["id"]);
    //if ($this->{model}->update_attributes($this->params["{model}"]))
    //  $this->redirect_to("index");
  }

  function add() {
    $this->article = new Article;
  }
 
}

