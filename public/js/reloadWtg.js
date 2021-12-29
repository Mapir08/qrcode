$(function(){

  $('#allLigne .date').click(function(){
    let info = {
      'majVersion' : 1,
      'equipement': '',
      'date': '',
      'serial': $(this).parent().find('.ligne_serial').text()
    };
    
    if ($(this).hasClass('ligne_Lift')) {
    info['equipement']='Lift';
    }else if ($(this).hasClass('ligne_RetE')) {
      info['equipement']='RailEchelle';
    }else if ($(this).hasClass('ligne_Ext')) {
      info['equipement']='Extincteur';
    }else if ($(this).hasClass('ligne_Crane')) {
      info['equipement']='Crane';
    }else if ($(this).hasClass('ligne_Resq')) {
      info['equipement']='ResQ';
    }
    let p = prompt('Indiquer une nouvelle date de fin de validité (jj/mm/yyyy) :');
    if (p !== null) {
      let newDate = p.split('/');
      let day= newDate[0];
      let month= newDate[1];
      let year= newDate[2];
      newDate = new Date(year, month-1, day);
      $(this).text(newDate.toLocaleDateString("fr-FR"));
      info['date'] = year +'-'+ month +'-'+ day;
      let dateActuel = new Date();
  
      if (newDate > dateActuel) {
        $(this).removeClass('error');
      }else{
        $(this).addClass('error');
      }
  
      $.ajax({
        type: 'POST',
        url: '../php/majDate.php',
        data: info
      });
    }
  });

});