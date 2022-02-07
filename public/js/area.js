$(function(){

  $('#area-add').submit(function(e){
    e.preventDefault();
    let postdata = $('#area-add').serialize();
    $.ajax({
      type: 'POST',
      url: '../php/addarea.php',
      data: postdata,
      success: function(){
        location.reload();
      }
    });
  });

  $('.area_del').click(function(){
    let area = {nom:$(this).siblings('.area_nom').text()};
    $.ajax({
      type: 'POST',
      url: '../php/delarea.php',
      data: area,
      success: function(){
        location.reload();
      }
    });
  });
});