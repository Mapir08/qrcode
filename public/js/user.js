$(function(){

  $('#user-add').submit(function(e){
    e.preventDefault();
    let postdata = $('#user-add').serialize();
    $.ajax({
      type: 'POST',
      url: '../php/adduser.php',
      data: postdata,
      success: function(){
        location.reload();
      }
    });
  });

  $('.user_del').click(function(){
    let initiale = {nom:$(this).siblings('.user_initial').text()};
    console.log(initiale);
    $.ajax({
      type: 'POST',
      url: '../php/deluser.php',
      data: initiale,
      success: function(erreur){
        console.log(erreur);
        location.reload();
      }
    });
  });
});