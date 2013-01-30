<?php 

class ElementsController extends Controller {

  function index() {
    $this->elements = Element::all();
  }

  function show() {
    $this->element = Element::find($this->params["id"]);
  }

  function edit() {
    $this->element = Element::find($this->params["id"]);
  }

  function destroy() {
    if (Element::find($this->params["id"])->delete())
      $this->redirect_to("index");
  }

  function create() {
    $element = new Element($this->params["article"]);
    if ($element->save())
      $this->redirect_to("index");
  }

  function update() {
    if (Element::find($this->params["id"])->update_attributes($this->params["element"]))
      $this->redirect_to("index");
  }

  function add() {
    $this->element = new Element;
  }
 
}

