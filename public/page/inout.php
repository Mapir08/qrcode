<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vestas QR-Code / In & Out</title>
  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
  <!-- FONT -->
  <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet"> <!-- caveat -->
  <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet"> <!-- Bangers -->
  <!-- SCRIPT -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="../js/inout.js"></script>
</head>
<body>
  <header class="container-fluid">
    <h1>Générer une entrée / sortie</h1>
  </header>
  <section class="container inout">

    <?php 
      require '../php/connect.php';
      if (isset($_GET['sn'])) {
        
        include("inoutQR.php");

      } elseif (isset($_GET['parc'])) {
    ?>
      <form method="get" id="new-inout-parc">
        <select name="parc" id="parc">
          <?php 
            $db = Database::connect();
            $tempo = $db->query('SELECT `nom` FROM `parc`');
            Database::disconnect();
            echo '<option value=""></option>';
            while ($row = $tempo->fetch(PDO::FETCH_ASSOC)){
              if ($row["nom"] == $_GET['parc']){
                echo '<option value="'.$row["nom"].'" selected>'.$row["nom"].'</option>';
              }else{
                echo '<option value="'.$row["nom"].'">'.$row["nom"].'</option>';
              }
            }
          ?>
        </select>
        <select name="pad" id="pad">
          <?php 
            $db = Database::connect();
            $tempo = $db->query('SELECT pad FROM wtg WHERE parc="'.$_GET['parc'].'"');
            Database::disconnect();
            echo '<option value=""></option>';
            while ($row = $tempo->fetch(PDO::FETCH_ASSOC)){
              echo '<option value="'.$row["pad"].'">'.$row["pad"].'</option>';
            }
          ?>
        </select>
      </form>
      <form  method="get" id="new-inout-sn">
        <input name="sn" id="sn" type="text" readonly="readonly">
        <button hidden>GO</button>
      </form>
      
    <?php
      } else {
    ?>
      <form method="get" id="new-inout-parc">
        <select name="parc" id="parc">
          <?php 
            $db = Database::connect();
            $tempo = $db->query('SELECT `nom` FROM `parc`');
            Database::disconnect();
            echo '<option value=""></option>';
            while ($row = $tempo->fetch(PDO::FETCH_ASSOC)){
              echo '<option value="'.$row["nom"].'">'.$row["nom"].'</option>';
            }
          ?>
        </select>
      </form>
    <?php
      }
    ?>

  </section>
  <footer class="container-fluid"><a href="../../index.html">retour</a></footer>
</body>
</html>