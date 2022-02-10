$(function(){

  $('.intervention').click(function(){
    if($(this).height() == 50){
      $(this).animate({height:'110px'}, 200);
    }else{
      $(this).animate({height:'50px'}, 200);
    }
  });

  $('#region').change(function(){
    let region = $(this).val();
    let parc = []; 
    $('.intervention').each(function(){
      if (region == $(this).children('.ligne').children('.region').text()){
        $(this).removeAttr('hidden');
        parc.push($(this).children('.ligne').children('.parc').text());
        $('#parc option[value=""]').prop('selected', true)
        $('#parc').removeAttr('disabled');
        $('#onsite').removeAttr('disabled');
      }else if (region ==""){
        $(this).removeAttr('hidden');
        parc.push($(this).children('.ligne').children('.parc').text());
        $('#parc').attr('disabled', true);
        $('#onsite').attr('disabled', true);
        $('#parc option[value=""]').prop('selected', true)
      }else{
        $(this).attr('hidden',true);
      }
    });
    var listeParc = [...new Set(parc)]
    $('#parc option').each(function(){
      $(this).attr('hidden',true);
    });
    $('#allParcs').removeAttr('hidden');
    for ( let i in listeParc){
      $('#'+listeParc[i].replace(/\s/g,'_')).removeAttr('hidden');
    }
  });

  $('#parc').change(function(){
    let parc = $(this).val();
    $('.intervention').each(function(){
      if ((parc == $(this).children('.ligne').children('.parc').text() || parc =="") && $(this).children('.ligne').children('.region').text() == $('#region').val()){
        $(this).removeAttr('hidden');
      }else{
        $(this).attr('hidden',true);
      }
    });
  });

  $('#onsite').click(function(){
    $('.intervention').each(function(){
      if (($(this).children('.ligne').children('.date').children('div:nth-child(2)').text() == "en cours" ) && $(this).children('.ligne').children('.region').text() == $('#region').val()) {
        $(this).removeAttr('hidden');
      }else{
        $(this).attr('hidden',true);
      }
    });
  });
});