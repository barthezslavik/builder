<?php 

class UsersController extends Controller {

  function index() {
    $this->users = User::all();
  }

  function show() {
    $this->user = User::find($this->params["id"]);
  }

  function edit() {
    $this->user = User::find($this->params["id"]);
  }

  function destroy() {
    if (User::find($this->params["id"])->delete())
      $this->redirect_to("index");
  }

  function create() {
    $user = new User($this->params["article"]);
    if ($user->save())
      $this->redirect_to("index");
  }

  function update() {
    if (User::find($this->params["id"])->update_attributes($this->params["user"]))
      $this->redirect_to("index");
  }

  function add() {
    $this->user = new User;
  }
 
}

