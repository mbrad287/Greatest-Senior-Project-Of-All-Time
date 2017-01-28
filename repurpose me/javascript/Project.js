/* 
Function name: resetcheck
Description: A function that is called after the reset button is clicked.
*/
function resetcheck()
{	
	if (confirm('Do you want to clear all the fields?'))
		{ 	
		document.getElementById("reset").type="reset";
		}
	else
		{	document.getElementById("reset").type="button";	} 
}

function displayFormData() {
  var form = $(".validated-form");
  var state;
  if(isValidated(form)) {
    var children = form.children('label');
    children.each(function() {
      document.writeln($(this).children('input').attr("name") + ": " + $(this).children('input').val() + "<br/>");
    });
  }
  return false;
}

/*
function isValidated(form) {
  var valid = true;
  var children = form.children('label.required');
  children.each(function() {
    var input = $(this).children("input");
    var value = input.val();
    if(value == "") {
      window.alert(input.attr("name") + " is empty");
      valid = false;
    }
    else {
      switch(input.attr("name")) {
        case "email":
          if(value.indexOf("@") == -1 || value.indexOf(".") == -1) {
            window.alert('email must contain a "@" and a "."');
            valid = false;
          }
          break;
        case "fname":
        case "lname":
          if(!isNaN(value)) {
            window.alert(input.attr("name") + ' can not be a number');
            valid = false;
          }
          break;
        case "phone":
        case "zip":
          if(isNaN(value)) {
            window.alert(input.attr("name") + ' must be numbers');
            valid = false;
          }
          break;
      }
    }
  });
  return valid;
} */