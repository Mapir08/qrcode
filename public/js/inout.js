$(function(){

  $('#new-inout-parc #parc').change(function(){
    $('#new-inout-parc').submit();
  });
  $('#new-inout-parc #pad').change(function(e){
    e.preventDefault();
    let postdata = $('#new-inout-parc').serialize();
    $.ajax({
      type: 'POST',
      url: '../php/searchserial.php',
      data: postdata,
      success: function(serial){
        $('#new-inout-sn #sn').val(serial); //Mettre serial une fois les tests fini !!!
        $('#new-inout-sn button').removeAttr('hidden');
      }
    });

  });


  
});