$(function(){

  $('#wtg-info input, #wtg-info select').change(function(){
    // let $this = $(this);
    // console.log($this.index());
    $('#wtg-info').submit();
  });
  $('#wtg-nb').submit(function(e){
    e.preventDefault();
    let postdata = $('#wtg-info').serialize() + '&' + $('#wtg-nb').serialize();
    // faire une condition pour dire si un champ obligatoire n'est pas rempli
    $.ajax({
      type: 'POST',
      url: '../php/addwtg.php',
      data: postdata,
      success: function(){
        window.location.href = 'wtg.php';
      }
    });
  });
});