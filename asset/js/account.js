
function checkInput(input, check) {
  if (check) {
    input.removeClass('wrong');
    input.addClass('correct');
    $('#login').attr("disabled", false);
  } else {
    input.removeClass('correct');
    input.addClass('wrong');
    $('#login').attr("disabled", true);
  }
}

function checkPassword(input) {
  input.on('keyup change submit', function() {
    if (input.val().length >= 6) {
      checkInput(input, true);
    } else {
      checkInput(input, false);
    }
  });
}

function checkPassword1(input1, input2) {
  input1.on('keyup change submit', function() {
    if (input1.val().length >= 6) {
      input1.removeClass('wrong');
      input1.addClass('correct');
    } else if (input1.val() == input2.val()) {
      input1.removeClass('wrong');
      input1.addClass('correct');
    } else if (input1.val() != input2.val()) {
      input2.removeClass('wrong');
      input2.removeClass('correct');
      input2.addClass('wrong1');
    } else if (input1.val() == '') {
      input2.removeClass('correct');
      input2.removeClass('wrong1');
      input2.addClass('wrong');
    }
  });

  input2.on('keyup change submit', function() {
    if ((input2.val().length >= 6) && (input1.val() == input2.val())) {
      input2.removeClass('wrong');
      input2.removeClass('wrong1');
      input2.addClass('correct');
    } else if (input1.val() != input2.val()) {
      input2.removeClass('wrong');
      input2.removeClass('correct');
      input2.addClass('wrong1');
    } else if (input2.val() == "") {
      input2.removeClass('correct');
      input2.removeClass('wrong1');
      input2.addClass('wrong');
    }
  });
}

function checkEmail(input) {
  input.on('keyup change submit', function() {
    var emailValue = input.val();

    var pattern = /^[a-zA-Z0-9\.]+@(gmail\.com|yahoo\.co\.uk|yahoo\.com|hotmail\.com)$/;

    if (pattern.test(emailValue)) {
      checkInput(input, true);
    } else {
      checkInput(input, false);
    }
  });
}

$(function() {
  checkPassword($('#password'));
  checkEmail($('#email'));

  checkPassword1($('#password1'), $('#password2'));

  $('#name').on('keyup change submit', function() {
    if ($(this).val().length > 0) {
      $(this).removeClass('wrong');
      $(this).addClass('correct');
    } else {
      $(this).removeClass('correct');
      $(this).addClass('wrong');
    }
  });

  $('#nickname').on('keyup change submit', function() {
    if ($(this).val().length > 0) {
      $(this).removeClass('wrong');
      $(this).addClass('correct');
    } else {
      $(this).removeClass('correct');
      $(this).addClass('wrong');
    }
  });

  $('#captcha').on('keyup change submit', function() {
    if ($(this).val() == $('#captcha1').val()) {
      $(this).removeClass('wrong');
      $(this).addClass('correct');
    } else {
      $(this).removeClass('correct');
      $(this).addClass('wrong');
    }

  });

});
