$(function(){

  $('#regionSelect #region').change(function(){
    $('#regionSelect').submit();
  });
  $('#parcSelect #parc').change(function(){
    $('#parcSelect button').removeAttr('hidden');
  });

  $('#raisonInter').change(function(){
    if ($('#choixSafety_none').is(":checked")==true) {
      $('#dateInter').attr('hidden', true);
    } else {
      $('#dateInter').removeAttr('hidden');
    }
  });
  $('#liste').change(function(){
    let choix = [];
    let choixHelp = [];
    let qty = 0;
    $('#liste input[type=checkbox]').each(function(){
      if (this.checked){
        choix.push($(this).siblings('label').children('span').eq(0).text());
        choixHelp.push($(this).siblings('label').children('span').eq(1).text());
      }
    });
    $('#listPB').html('');
    $('#listPB').append('<div class="sommaire"><div class="titre">Turbine n°</div></div>');
    $('#listPB .sommaire').append('<div class="pbLift">Lift</div>');
    $('#listPB .sommaire').append('<div class="pbCrane">Crane</div>');
    $('#listPB .sommaire').append('<div class="pbRE">Rail/Echelle</div>');
    $('#listPB .sommaire').append('<div class="pbExct">Extincteur</div>');
    $('#listPB .sommaire').append('<div class="pbResq">ResQ</div>');
    $('#listPB').append('<div class="listeWTG"></div>');

    choix.forEach(e => {
      let colored = (qty%2 == 0) ? "" : " colored"; 
      $('#listPB .listeWTG').append('<div class="eachWTG"><div class="titre'+colored+'">'+e+'</div></div>');
      $('#listPB .listeWTG .eachWTG').eq(qty).append('<div class="pbLift'+colored+'"><input type="checkbox"></div>');
      $('#listPB .listeWTG .eachWTG').eq(qty).append('<div class="pbCrane'+colored+'"><input type="checkbox"></div>');
      $('#listPB .listeWTG .eachWTG').eq(qty).append('<div class="pbRE'+colored+'"><input type="checkbox"></div>');
      $('#listPB .listeWTG .eachWTG').eq(qty).append('<div class="pbExct'+colored+'"><input type="checkbox"></div>');
      $('#listPB .listeWTG .eachWTG').eq(qty).append('<div class="pbResq'+colored+'"><input type="checkbox"></div>');
      qty+=1;
    });
    
    let eachWTG = $('.eachWTG');
    eachWTG.each(function(){
      let serial = choixHelp[choix.indexOf($(this).children('.titre').text())];
      let inputLift = $(this).children('.pbLift').children('input');
      let inputCrane = $(this).children('.pbCrane').children('input');
      let inputRE = $(this).children('.pbRE').children('input');
      let inputExct = $(this).children('.pbExct').children('input');
      let inputResq = $(this).children('.pbResq').children('input');
      $.ajax({
        type: 'POST',
        url: '../php/searchPB.php',
        data: { serial: serial },
        dataType : 'json',
        success: function(retour){
          if ( retour['pbLift'] == 'oui' ){ inputLift.attr('checked', true); }
          if ( retour['pbRaiEch'] == 'oui' ){ inputRE.attr('checked', true); }
          if ( retour['pbExc'] == 'oui' ){ inputExct.attr('checked', true); }
          if ( retour['pbCrane'] == 'oui' ){ inputCrane.attr('checked', true); }
          if ( retour['pbResq'] == 'oui' ){ inputResq.attr('checked', true); }
        }
      });
    });

    if (choix.length == 0 ){
      $('#sendInfo').attr('hidden', true);
      $('#listPB').html('');
    }else{
      $('#sendInfo').removeAttr('hidden');
    }

  });
  $('#sendInfo').click(function(){
    let listePB = [];
    let wtg = [];
    let nom = [];
    let i = 0;
    let j = 0; 
    $('#liste .liste_WTG input[type=checkbox]').each(function(){
      if ($(this).is(':checked')) {
        nom.push($(this).siblings('label').children('.spanSerial').text());
      } 
    });
    // [0]= Serial / [1]= Lift / [2]= Crane / [3]= R-E / [4]= Extincteur / [5]= ResQ  
    $('.listeWTG .eachWTG div input[type=checkbox]').each(function(){
      if ($(this).is(':checked')) {
        wtg.push('oui');
      } else {
        wtg.push('non');
      }
      i += 1;
      if (i == 5) {
        wtg.unshift(nom[j]);
        j+=1;
        listePB.push(wtg);
        wtg = [];
        i = 0;
      }
    });
    
    if ($('#choixSafety_none').is(":checked")==true) {
      listePB.forEach(function(e){
        let saveList = {
          serial : e[0],
          lift : e[1],
          crane : e[2],
          RE : e[3],
          exct : e[4],
          resq : e[5],
        };
        $.ajax({
          type: 'POST',
          url: '../php/savePB.php',
          data: saveList
        });
      });
    }else if ($('#choixSafety_lift').is(":checked")==true) {
      listePB.forEach(function(e){
        let saveList = {
          date : $('#dateInter').val(),
          type : "lift",
          serial : e[0],
          lift : e[1],
          crane : e[2],
          RE : e[3],
          exct : e[4],
          resq : e[5],
        };
        $.ajax({
          type: 'POST',
          url: '../php/savePB.php',
          data: saveList
        });
      });
    }else if ($('#choixSafety_complet').is(":checked")==true) {
      listePB.forEach(function(e){
        let saveList = {
          date : $('#dateInter').val(),
          type : "complet",
          serial : e[0],
          lift : e[1],
          crane : e[2],
          RE : e[3],
          exct : e[4],
          resq : e[5],
        };
        $.ajax({
          type: 'POST',
          url: '../php/savePB.php',
          data: saveList
        });
      });
    }

    window.open('safety.php', "_self");
  });
});