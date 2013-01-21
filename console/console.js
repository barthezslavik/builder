$(document).ready(function() {
  variants = ["g scaffold", "g model", "g controller"]
  $("#console").focus();

  var history = $("#screen").html();
  if (history) {
    history = history.split("<br>");
    history = history.slice(0, history.length-1);
    var cursor = history.length;
  }

  $("#console").keyup(function(e) {
    console.log(e.keyCode);
    switch(e.keyCode) {
      case 8: {
      }

      case 40: {
        variants = $("#autocomplete").find("div");
        console.log(variants);
      }

      case 38: {
        if (cursor > 0) { 
          cursor--;
          $(this).val(history[cursor]);
        }
      }

      default: {
        var current_value = $("#console").val();
        $.each(variants, function(index, value) {
          if (value.match(current_value)) {
            console.log(value);
          }
        });
      }
    }
  });
});
