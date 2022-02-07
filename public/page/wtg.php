<?php
  if (isset($_POST['pwd'])){
    setcookie("pwd", $_POST['pwd'], time()+3600);
    header("Refresh:0");
  }
?>

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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="../js/wtg.js"></script>
</head>
<body>
  <header class="container-fluid">
    <h1>Listes des turbines</h1>
  </header>

  <?php 
    require '../php/connect.php';
    require '../php/pass.php';
    if (isset($_COOKIE['pwd']) && $_COOKIE['pwd']==$pass){
  ?>

  <section class="container wtg">
    <div class="row">
      <select id="wtg_regionSelect" placeholder="Région" class="wtg_regionSelect botn">
        <option value="" selected>Régions</option>
        <?php
          $db = Database::connect();
          $tempo = $db->query('SELECT `nomRegion` FROM `regions`');
          Database::disconnect();
          while ($row = $tempo->fetch(PDO::FETCH_ASSOC)){
            echo '<option value="'.$row["nomRegion"].'">'.$row["nomRegion"].'</option>';
          }
        ?>
      </select>
      <div class="wtg_add"><a href="wtgadd.php?nom=&abv=&region=&nb=&tel=&client=" class="botn">Nouveau</a></div>
    </div>
    <div class="wtg_entete">
      <div class="wtg_region">Region</div>
      <div class="wtg_Parc">Parc</div>
      <div class="wtg_Abv">Abreviation</div>
      <div class="wtg_Client">Client</div>
      <div class="wtg_Tel">Téléphone</div>
    </div>
    <div id='wtg_ligne'>
    <?php
      $db = Database::connect();
      $tempo = $db->query('SELECT `nom`,`tel`,`client`,`region`,`abreviation` FROM `parc`');
      Database::disconnect();
      while ($row = $tempo->fetch(PDO::FETCH_ASSOC)){
        echo '<div class="wtg_ligne">
                <div class="wtg_region">'.$row["region"].'</div>
                <div class="wtg_parc">'.$row["nom"].'</div>
                <div class="wtg_abv">'.$row["abreviation"].'</div>
                <div class="wtg_client">'.$row["client"].'</div>
                <div class="wtg_tel">'.$row["tel"].'</div>
                <div class="wtg_del"><span>x</span></div>
              </div>';
      }
    ?>
    </div>
  </section>

  <section id="popup" hidden>
      <span id="closer">X</span>
      <h4>Nom du Parc</h4>
      <div class="fenetre">
        <div class="entete">
          <div class="entete_pad">N°</div>
          <div class="entete_serial">Serial</div>
          <div class="entete_Lift">Next date<span class="sautligne">Lift</span></div>
          <div class="entete_RetE">Next date<span class="sautligne">Rail/Echelle</span></div>
          <div class="entete_Ext">Next date<span class="sautligne">Extincteur</span></div>
          <div class="entete_Crane">Next date<span class="sautligne">Crane</span></div>
          <div class="entete_Resq">Validité<span class="sautligne">ResQ</span></div>
        </div>
        <div id="allLigne">
        </div>
      </div>
  </section>
  
  <footer class="container-fluid"><a href="../../index.php">retour</a></footer>
  <?php
    }
    else
    {
  ?>
  <form method="POST" action="wtg.php" id="user-password" enctype="multipart/form-data" class="container">
      <input name="pwd" id="pwd" type="password" placeholder="Password" autocomplete="off">
      <button type="submit" id='pwdGo'>Go</button>
  </form>
  <?php
    }
  ?>

</body>
</html>