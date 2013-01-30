<?php 

class TestsController extends Controller {

  function index() {
    $this->tests = Test::all();
  }

  function show() {
    $this->test = Test::find($this->params["id"]);
  }

  function edit() {
    $this->test = Test::find($this->params["id"]);
  }

  function destroy() {
    if (Test::find($this->params["id"])->delete())
      $this->redirect_to("index");
  }

  function create() {
    $test = new Test($this->params["article"]);
    if ($test->save())
      $this->redirect_to("index");
  }

  function update() {
    if (Test::find($this->params["id"])->update_attributes($this->params["test"]))
      $this->redirect_to("index");
  }

  function add() {
    $this->test = new Test;
  }
 
}

