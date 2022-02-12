$(function(){

  $('#parc').change(function(){
    $('#printArea').html("");
    let postdata = $('#print').serialize();
    let parc = {nom: $('#parc').val()};
    let abv = "";
    $.ajax({
      type: 'POST',
      url: '../php/searchAbv.php',
      data: parc,
      success: function(retour){
        abv = retour;
      }
    });
    $.ajax({
      type: 'POST',
      url: '../php/listWTG.php',
      data: postdata,
      dataType: 'json',
      success: function(retour){
        retour.forEach(ligne => {
          let titre = ligne['serial']+"_"+abv+"_"+ligne['pad'] ;
          $("#printArea").append('\
            <div class="printQR">\
              <div class="printQR_logo"><img src="../img/VestasLogo.png" alt="Logo Vestas"></div>\
              <div class="printQR_titre">'+titre+'</div>\
              <div class="printQR_qr"><img src="../img/qr/'+ligne['serial']+'.png" alt="QR Code '+ligne['serial']+'"></div>\
              <div class="printQR_qrText"><i class="bi bi-capslock-fill"></i> Please scan before and after your job <i class="bi bi-capslock-fill"></i></div>\
              <div class="printQR_safety">\
                <p><span>QR code SAFETY</span></br>\
                <span>For safety inspection or problem find on a safety component (lift, ladder, rail, crane, extinguisher)</span></p>\
                <img src="../img/qr/safety.png" alt="QR Code pour le Safety">\
              </div>\
            </div>');
        });
      }
    });
  });

  $('#printBtn').click(function(e){
    e.preventDefault();
    function print (){
      $('*').removeClass('wait');
      window.print()
    }
    $('*').addClass('wait');
    window.setTimeout(print, 5000)
  });

});