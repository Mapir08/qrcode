$(function(){

  $('#wtg-info input, #wtg-info select').change(function(){
    $('#wtg-info').submit();
  });
  $('#wtg-nb').submit(function(e){
    e.preventDefault();
    let postdata = $('#wtg-info').serialize() + '&' + $('#wtg-nb').serialize();
    // faire une condition pour dire si un champ obligatoire n'est pas rempli
    var array = {};
    $.each($("#wtg-info").serializeArray(), function (i, field) {
      array[field.name] = field.value;
    });
    $.each($("#wtg-nb").serializeArray(), function (i, field) {
      array[field.name] = field.value;
    });

    let validation = true;
    if (!array['nom']) {
      validation=false;
      $('#wtg-info #nom').css('border-color', 'red');
      $('#wtg-info #nom').prev().css('color', 'red');
    } else {
      $('#wtg-info #nom').css('border-color', '#b6b6b6');
      $('#wtg-info #nom').prev().css('color', 'black');
    }
    if (!array['abv']) {
      validation=false;
      $('#wtg-info #abv').css('border-color', 'red');
      $('#wtg-info #abv').prev().css('color', 'red');
    } else {
      $('#wtg-info #abv').css('border-color', '#b6b6b6');
      $('#wtg-info #abv').prev().css('color', 'black');
    }
    if (!array['region']) {
      validation=false;
      $('#wtg-info #region').css('border-color', 'red');
      $('#wtg-info #region').prev().css('color', 'red');
    } else {
      $('#wtg-info #region').css('border-color', '#b6b6b6');
      $('#wtg-info #region').prev().css('color', 'black');
    }

    for ( let x=0 ; x < array['nb'] ; x++) {
      if (!array['serial'+x] || !array['pad'+x]){
        validation = false;
        $('#wtg-nb input').css('border-color', 'red');
      } else {
        $('#wtg-nb input').css('border-color', '#b6b6b6');
      }
    }

    if (validation) {
      $.ajax({
        type: 'POST',
        url: '../php/addwtg.php',
        data: postdata,
        success: function(){
          window.open('wtg.php', "_self");
        }
      });
    }
  });
});