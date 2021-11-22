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

  $('#inoutQR #pauseO_N').click(function(){
    if($('#inoutQR #pauseO_N').prop('checked')){
      $('#inoutQR #stopDate').parent().removeAttr('hidden');
      $('#inoutQR #stopHour').parent().removeAttr('hidden');
    }else{
      $('#inoutQR #stopDate').parent().attr('hidden', true);
      $('#inoutQR #stopDate').val(null);
      $('#inoutQR #stopHour').parent().attr('hidden', true);
      $('#inoutQR #stopHour').val(null);
    }
  });
  
  $('#inoutQR').submit(function(e){
    e.preventDefault();
    let arrayIN = [];
    arrayIN.push({name:'serial', value:$('#inoutQR #serial').text()});
    if ($('#inoutQR #pauseO_N').is(':checked')){
      arrayIN.push({name:'pauseO_N', value:"checked"});
    }else{
      arrayIN.push({name:'pauseO_N', value:"notchecked"});
    }
    arrayIN.push({name:'stopDate', value:$('#inoutQR #stopDate').val()});
    arrayIN.push({name:'stopHour', value:$('#inoutQR #stopHour').val()});
    arrayIN.push({name:'t1', value:$('#inoutQR #t1').val()});
    arrayIN.push({name:'t2', value:$('#inoutQR #t2').val()});
    arrayIN.push({name:'t3', value:$('#inoutQR #t3').val()});
    arrayIN.push({name:'so', value:$('#inoutQR #so').val()});
    arrayIN.push({name:'detail', value:$('#inoutQR #detail').val()});    
    let arrayOUT = [];
    arrayOUT.push({name:'startDate', value:$('#inoutQR #startDate').val()});
    arrayOUT.push({name:'startHour', value:$('#inoutQR #startHour').val()});
    arrayOUT.push({name:'cr', value:$('#inoutQR #cr').val()});

    if ($('#inoutQR #io').text() == 'IN') {
      $.ajax({
        type: 'POST',
        url: '../php/saveIn.php',
        data: arrayIN,
        dataType: 'json',
        success: function(retour){
          if (!retour.tech){$('#t1').addClass('error');} else {$('#t1').removeClass('error');}
          if (!retour.so){$('#so').addClass('error');} else {$('#so').removeClass('error');}
          if (!retour.detail){$('#detail').addClass('error');} else {$('#detail').removeClass('error');}
          if (!retour.date){$('#stopDate').addClass('error');$('#stopHour').addClass('error');} else {$('#stopDate').removeClass('error');$('#stopHour').removeClass('error');}
        }
        //Si téléphone présent sur le parc, indiquer qu'il faut appeler !!
        //Fermer la page, ou rediriger vers une page de fin.
      });
    } else if ($('#inoutQR #io').text() == 'OUT') {

    }
  });


});