<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vestas QR-Code / Turbines</title>
  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
  <!-- FONT -->
  <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet"> <!-- caveat -->
  <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet"> <!-- Bangers -->
  <!-- SCRIPT -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>
  <header class="container-fluid">
    <h1>Listes des turbines</h1>
  </header>
  <?php 
    require '../php/connect.php';
  ?>
  <section class="container wtg">
    <div class="wtg_add"><a href="wtgadd.php?nom=&abv=&region=&nb=&tel=&mail=" class="botn">Nouveau</a></div>
    <div class="wtg_entete">
      <div class="wtg_region">Région</div>
      <div class="wtg_serial">Serial</div>
      <div class="wtg_parc">Parc</div>
      <div class="wtg_pad">N°</div>
    </div>
    <?php
      $db = Database::connect();
      $tempo = $db->query('SELECT wtg.serial, wtg.parc, wtg.pad, parc.region FROM wtg INNER JOIN parc ON parc.nom=wtg.parc');
      Database::disconnect();
      while ($row = $tempo->fetch(PDO::FETCH_ASSOC)){
        echo '<div class="wtg_ligne">
                <div class="wtg_region">'.$row['region'].'</div>
                <div class="wtg_serial">'.$row["serial"].'</div>
                <div class="wtg_parc">'.$row["parc"].'</div>
                <div class="wtg_pad">'.$row["pad"].'</div>
              </div>';
      }
    ?>
  </section>
  
  <footer class="container-fluid"><a href="../../index.html">retour</a></footer>
</body>
</html>