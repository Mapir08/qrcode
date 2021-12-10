$(function(){

  function copyToClipboard(text) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(text).select();
    document.execCommand("copy");
    $temp.remove();
  }

  $('.ligne').hover(function(){
    $(this).css("background-color", "#a0cfeb");
  }, function(){
    $(this).css("background-color", "");
  });

  $('#listSerial .ligne_serial').click(function(){
    $('#sn').text($(this).text());
    $('#copier').removeAttr('hidden');
    $('#form').removeAttr('hidden');
  });

  $('#copier').click(function(){
    copyToClipboard($('#lien').text());
  });
});