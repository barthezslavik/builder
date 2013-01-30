<?php 

class @controllerController extends Controller {

  function index() {
    $this->@plural = @model::all();
  }

  function show() {
    $this->@singular = @model::find($this->params["id"]);
  }

  function edit() {
    $this->@singular = @model::find($this->params["id"]);
  }

  function destroy() {
    if (@model::find($this->params["id"])->delete())
      $this->redirect_to("index");
  }

  function create() {
    $@singular = new @model($this->params["article"]);
    if ($@singular->save())
      $this->redirect_to("index");
  }

  function update() {
    if (@model::find($this->params["id"])->update_attributes($this->params["@singular"]))
      $this->redirect_to("index");
  }

  function add() {
    $this->@singular = new @model;
  }
 
}
