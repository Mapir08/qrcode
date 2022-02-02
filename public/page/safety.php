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
  <title>Vestas QR-Code / Safety Inspections</title>
  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
  <!-- FONT -->
  <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet"> <!-- caveat -->
  <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet"> <!-- Bangers -->
  <!-- SCRIPT -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="../js/safety.js"></script>
</head>
<body>
  <header class="container-fluid">
      <h1>Safety inspection date</h1>
  </header>

  <?php 
    require '../php/connect.php';
    function verif($var){
      $var=strip_tags($var);
      return $var;
    }
    if (isset($_COOKIE['pwd']) && $_COOKIE['pwd']=='Welcome123'){

  ?>
  <section id="safety">

    <?php
      if (isset($_GET['parc'])){
    ?>
      <h2><?php echo ($_GET['parc']) ?></h2>
      
      <form id="raisonInter">
        <div>Raison d'intervention : </div>
        <div>
          <div class="raison">
            <input type="radio" id="choixSafety_none" name="choixSafety" value="none" checked hidden><label for="choixSafety_none">Aucunes</label>
          </div>
          <div class="raison">
            <input type="radio" id="choixSafety_lift" name="choixSafety" value="lift" hidden><label for="choixSafety_lift">Inspection Lift</label>
          </div>
          <div class="raison">
            <input type="radio" id="choixSafety_complet" name="choixSafety" value="complet" hidden><label for="choixSafety_complet">Inspection Complète</label>
          </div>
        </div>
        <input type="date" name="dateInter" id="dateInter" autocomplete="off" hidden>
      </form>

      <form id="liste">
        <div>Liste des machines :</div>
        <?php
          $db = Database::connect();
          $liste = $db->query('SELECT `serial`, `pad`, `pbLift`, `pbRaiEch`, `pbExc`, `pbCrane`, `pbResq` FROM `wtg` WHERE parc="'.$_GET['parc'].'"');
          Database::disconnect();
          while ($row = $liste->fetch(PDO::FETCH_ASSOC)){
            echo '<div class="liste_WTG"><input id="'.$row['serial'].'" name="'.$row['serial'].'" type="checkbox" hidden><label for="'.$row['serial'].'"><span class="spanPad">'.$row['pad'].'</span><span class="spanSerial">'.$row['serial'].'</span></label></div>';
          }
        ?>
      </form>

      <form method="post" id="listPB">
      </form>
      
      <div id="sendInfo" class="botn" hidden>SEND</div>

    <?php
      }else if (isset($_GET['region'])){
    ?>
  <form id="regionSelect" method="get">
      <select name="region" id="region">
        <?php 
          $db = Database::connect();
          $tempo = $db->query('SELECT `nomRegion` FROM `regions`');
          Database::disconnect();
          echo '<option value="" disabled>Area</option>';
          while ($row = $tempo->fetch(PDO::FETCH_ASSOC)){
            if ($row['nomRegion']==$_GET['region']){
              echo '<option value="'.$row["nomRegion"].'" selected>'.$row["nomRegion"].'</option>';
            }else{
              echo '<option value="'.$row["nomRegion"].'">'.$row["nomRegion"].'</option>';
            }
          }
        ?>
      </select>
  </form>
  <form id="parcSelect" method="get">
      <select name="parc" id="parc">
        <?php 
          $db = Database::connect();
          $tempo = $db->query('SELECT `nom` FROM `parc` WHERE region="'.$_GET['region'].'"');
          Database::disconnect();
          echo '<option value="" disabled selected>Parc</option>';
          while ($row = $tempo->fetch(PDO::FETCH_ASSOC)){
            echo '<option value="'.$row["nom"].'">'.$row["nom"].'</option>';
          }
        ?>
      </select>
      <button hidden>Send</button>
  </form>
    <?php
      }else{
    ?>
  <form id="regionSelect" method="get">
      <select name="region" id="region">
        <?php 
          $db = Database::connect();
          $tempo = $db->query('SELECT `nomRegion` FROM `regions`');
          Database::disconnect();
          echo '<option value="" disabled selected>Area</option>';
          while ($row = $tempo->fetch(PDO::FETCH_ASSOC)){
            echo '<option value="'.$row["nomRegion"].'">'.$row["nomRegion"].'</option>';
          }
        ?>
      </select>
  </form>
    <?php
      }
    ?>
  </section>
  <footer class="container-fluid"><a href="../../index.php">retour</a></footer>
  <?php
    }else{
  ?>
  <form method="POST" action="safety.php" id="user-password" enctype="multipart/form-data" class="container">
      <input name="pwd" id="pwd" type="password" placeholder="Password" autocomplete="off">
      <button type="submit" id='pwdGo'>Go</button>
  </form>
  <?php
    }
  ?>
  
</body>
</html>
