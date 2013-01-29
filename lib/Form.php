<?php

class Form {

  function __construct() {
    $form = Form::build(func_get_args());
    $this->model = Support::singularize($_REQUEST["controller"]);
    $this->action = $_REQUEST["action"];
    $this->object = $form->object;
    $model = $this->model."[id]";
    $action = "/".Support::pluralize($this->model);
    $put = "";
    if (array_key_exists("id", $this->object->attributes())) {
      $id = implode("_",array($this->action, $this->model, $form->object->id));
      $put = '<input name="_method" type="hidden" value="put">';
      $action = $action."/".$form->object->id;
    }
    else
      $id = "new_".$this->model;
    echo <<<FORM
    <form accept-charset="UTF-8" action="$action" class="$id" id="$id" method="$form->method">
    $put
FORM;
  }

  function input() {
    $input = Form::build(func_get_args());
    $id = "{$this->model}_$input->object";
    $name = "{$this->model}[$input->object]";
    $placeholder = (property_exists($input, "placeholder")) ? $input->placeholder : "";
    $size = (property_exists($input, "size")) ? $input->size : 37;
    $cols = (property_exists($input, "cols")) ? $input->cols : 40;
    $rows = (property_exists($input, "rows")) ? $input->rows : 10;
    $value = $this->action == "edit" ? $this->object->{$input->object} : "";
    $label = ucfirst($input->object);
    echo <<<LABEL
    <label for="$id">$label</label>\n
LABEL;
    $text_area_tag = <<<TEXTAREA
    <textarea id="$id" name="$name" cols="$cols" rows="$rows">$value</textarea>\n
TEXTAREA;
    $input_tag = <<<INPUT
    <input type="text" id="$id" name="$name" size="$size" placeholder="$placeholder" value="$value">\n
INPUT;
    print (@$input->as == "text") ? $text_area_tag : $input_tag;
  }

  function button() {
    $value = ($this->action == "edit") ? "Update " : "Create ";
    $value = $value.ucfirst($this->model);
    echo <<<BUTTON
    <input name="commit" type="submit" value="$value">\n</form>\n
BUTTON;
  }

  function association() {
    $select = Form::build(func_get_args());
    $id = "{$this->model}_$select->object";
    $label = ucfirst($select->object);
    $name = ucfirst($select->object);
    $association_items = call_user_func($name."::all");
    echo <<<LABEL
    <label for="$id">$label</label>\n
LABEL;
    echo <<<SELECT
    <select class="select optional" id="{$this->model}_user_id" name="{$this->model}[user_id]">\n
SELECT;
    if (property_exists($select, "prompt")) {
    echo <<<PROMPT
    <option value="">$select->prompt</option>\n
PROMPT;
    }
    foreach($association_items as $item) {
    if(property_exists($this->object, "id"))
      $selected = ($this->object->id == $item->id) ? 'selected="selected"' : "";
    else 
      $selected = "";
    echo <<<OPTIONS
    <option value="$item->id" $selected>$item->name</option>\n
OPTIONS;
    }
    echo <<<END_SELECT
    </select>\n
END_SELECT;
  }

  function build($attrs) {
    $data = new stdClass();
    $data->object = $attrs[0];
    array_shift($attrs);
    foreach($attrs as $value) {
      $value = explode(":",$value);
      $data->{$value[0]} = $value[1];
    }
    return $data;
  }

}
