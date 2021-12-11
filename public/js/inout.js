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
        $('#new-inout-sn #sn').val(serial);
        $('#new-inout-sn button').removeAttr('hidden');
      }
    });

  });

  $('#inoutQR #pauseO_N').click(function(){
    if($('#inoutQR #pauseO_N').prop('checked')){
      $('#inoutQR #stopDate').removeAttr('hidden');
      $('#inoutQR #stopHour').removeAttr('hidden');
    }else{
      $('#inoutQR #stopDate').attr('hidden', true);
      $('#inoutQR #stopDate').val(null);
      $('#inoutQR #stopHour').attr('hidden', true);
      $('#inoutQR #stopHour').val(null);
    }
  });
  
  $('#inoutQR #runO_N').click(function(){
    if($('#inoutQR #runO_N').prop('checked')){
      $('#inoutQR #startDate').removeAttr('hidden');
      $('#inoutQR #startHour').removeAttr('hidden');
    }else{
      $('#inoutQR #startDate').attr('hidden', true);
      $('#inoutQR #startDate').val(null);
      $('#inoutQR #startHour').attr('hidden', true);
      $('#inoutQR #startHour').val(null);
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
    arrayIN.push({name:'telephone', value:$('#inoutQR #telephone').val()});
    arrayIN.push({name:'company', value:$('#inoutQR #company').val()});
    arrayIN.push({name:'so', value:$('#inoutQR #so').val()});
    arrayIN.push({name:'detail', value:$('#inoutQR #detail').val()});    
    let arrayOUT = [];
    arrayOUT.push({name:'id', value:$('#inoutQR #rowID').text()});
    arrayOUT.push({name:'paused', value:$('#inoutQR #paused').text()});
    arrayOUT.push({name:'startDate', value:$('#inoutQR #startDate').val()});
    arrayOUT.push({name:'startHour', value:$('#inoutQR #startHour').val()});
    arrayOUT.push({name:'cr', value:$('#inoutQR #cr').val()});
    if ($('#inoutQR #runO_N').is(':checked')){
      arrayOUT.push({name:'runO_N', value:"oui"});
    }else{
      arrayOUT.push({name:'runO_N', value:"non"});
    }

    if ($('#inoutQR #io').text() == 'IN') {
      $.ajax({
        type: 'POST',
        url: '../php/saveIn.php',
        data: arrayIN,
        dataType: 'json',
        success: function(retour){
          let confirm=true;
          if (!retour.tech){$('#t1').addClass('error');confirm=false;} else {$('#t1').removeClass('error');}
          if (!retour.detail){$('#detail').addClass('error');confirm=false;} else {$('#detail').removeClass('error');}
          if (!retour.date){$('#stopDate').addClass('error');$('#stopHour').addClass('error');confirm=false;} else {$('#stopDate').removeClass('error');$('#stopHour').removeClass('error');}
          if (!retour.tel && ($('#telephone').val()=="")){
            alert("You are not in the database, can you please give us a phone number and company name ?");
            $('#telephone').removeAttr('hidden');
            $('#telephone').addClass('error');
            confirm=false;
          }else{
            $('#telephone').attr('hidden',true);
            $('#telephone').removeClass('error');
          };
          if (!retour.company && ($('#company').val()=="")){
            $('#company').removeAttr('hidden');
            $('#company').addClass('error');
            confirm=false;
          }else{
            $('#company').attr('hidden',true);
            $('#company').removeClass('error');
          };
          if (confirm) {
            window.open('end.php?serial='+$('#inoutQR #serial').text()+'&when=in', "_self");
          }
        }
      });
    } else if ($('#inoutQR #io').text() == 'OUT') {
      $.ajax({
        type: 'POST',
        url: '../php/saveOut.php',
        data: arrayOUT,
        dataType: 'json',
        success: function(retour){
          let confirm = true;
          if (!retour.date){$('#startDate').addClass('error');$('#startHour').addClass('error');confirm=false;} else {$('#startDate').removeClass('error');$('#startHour').removeClass('error');}
          if (!retour.cr){$('#cr').addClass('error');confirm=false;} else {$('#cr').removeClass('error');}
          if (confirm) {
            window.open('end.php?serial='+$('#inoutQR #serial').text()+'&when=out', "_self");
          }
        }
      });
    }
  });
});