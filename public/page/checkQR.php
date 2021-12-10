<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vestas QR-Code / Vérification si QR-Code Créé</title>
  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
  <!-- FONT -->
  <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet"> <!-- caveat -->
  <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet"> <!-- Bangers -->
  <!-- SCRIPT -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="../js/checkQR.js"></script>
</head>
<body>
  <header class="container-fluid">
    <h1>Vérification si QR-Code Créé</h1>
  </header>
  <?php 
    require '../php/connect.php';
  ?>
  <section class="container" id="checkQR">
    <h3>A copier pour la creation du QR-Code :</h3>
    <span id="lien">https://qr.mapir.net/public/page/inout.php?sn=<span id="sn"></span></span><span id="copier" class="botn" hidden>Copier</span>
    <h5>Listes QR Code non créé en fonctione des WTG enregistré dans la database :</h5>
    <div id="listSerial">
      <?php
        $pdo = Database::connect();
        $resultat = $pdo -> query('SELECT wtg.serial AS `Serial`, wtg.pad AS `Pad`, parc.nom AS `Parc` FROM wtg JOIN parc ON parc.nom = wtg.parc');
        Database::disconnect();

        while ($row = $resultat->fetch(PDO::FETCH_ASSOC)){
          $qrImg = "../img/qr/".$row["Serial"].".png";
          if (!file_exists($qrImg)){
            echo '<div class="ligne">
                    <div class="ligne_serial">'.$row["Serial"].'</div>
                    <div class="ligne_pad">'.$row["Pad"].'</div>
                    <div class="ligne_parc">'.$row["Parc"].'</div>
                  </div>';
          }
        }
      ?>

    </div>
  </section>
  
  <footer class="container-fluid"><a href="../../index.html">retour</a></footer>
</body>
</html>