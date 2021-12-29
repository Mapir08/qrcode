$(function(){

  function load_js()
  {
     var head= document.getElementsByTagName('head')[0];
     var script= document.createElement('script');
     script.src= '../js/reloadWtg.js';
     script.id='tempoScript';
     head.appendChild(script);
  }
  
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

  $('#wtg_regionSelect').change(function(){
    let selection = $(this).val();
    $('#wtg_ligne .wtg_ligne').each(function(){
      if (selection == $(this).children('.wtg_region').text() || selection ==""){
        $(this).removeAttr('hidden');
      }else{
        $(this).attr('hidden',true);
      }
    });
  });

  $('.wtg_parc').click(function(){
    postdata = {parc:$(this).text()};
    $('#popup h4').text($(this).text());
    $('#popup').removeAttr('hidden');
    $.ajax({
      type: 'POST',
      url: '../php/listWTG.php',
      data: postdata,
      dataType: 'json',
      success: function(retour){
        for (const ligne of retour){
          let pbLift = "";
          let pbRaiEch = "";
          let pbExc= "";
          let pbResq = "";
          let pbCrane = "";

          const today = new Date();
          const dateLift = new Date(ligne['dateInspLift']);
          const dateRaiEchExc = new Date(ligne['dateInspRaiEchExc']);
          const dateCrane = new Date(ligne['dateInspCrane']);
          const dateResq = new Date(ligne['dateValidResq']);

          if(ligne['pbLift']=="oui" || dateLift<today){ pbLift="error" }
          if(ligne['pbRaiEch']=="oui" || dateRaiEchExc<today){ pbRaiEch="error" }
          if(ligne['pbExc']=="oui" || dateRaiEchExc<today){ pbExc="error" }
          if(ligne['pbCrane']=="oui" || dateCrane<today){ pbCrane="error" }
          if(ligne['pbResq']=="oui" || dateResq<today){ pbResq="error" }

          $('#allLigne').append('\
            <div class="ligne">\
              <div class="ligne_pad">'+ligne['pad']+'</div>\
              <div class="ligne_serial">'+ligne['serial']+'</div>\
              <div class="ligne_Lift date '+pbLift+'">'+dateLift.toLocaleDateString("fr-FR")+'</div>\
              <div class="ligne_RetE date '+pbRaiEch+'">'+dateRaiEchExc.toLocaleDateString("fr-FR")+'</div>\
              <div class="ligne_Ext date '+pbExc+'">'+dateRaiEchExc.toLocaleDateString("fr-FR")+'</div>\
              <div class="ligne_Crane date '+pbCrane+'">'+dateCrane.toLocaleDateString("fr-FR")+'</div>\
              <div class="ligne_Resq date '+pbResq+'">'+dateResq.toLocaleDateString("fr-FR")+'</div>\
            </div>');
        }
        load_js();
      }
    });
  });
  $('#closer').click(function(){
    $('#popup').attr('hidden',true);
    $('#allLigne .ligne').remove();
    $('#tempoScript').remove();
  });

  $('#alligne .ligne').click(function(){
    console.log($(this).text());
  });

});