<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vestas QR-Code / End</title>
  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
  <!-- FONT -->
  <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet"> <!-- caveat -->
  <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet"> <!-- Bangers -->
  <!-- SCRIPT -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="../js/end.js"></script>
</head>
<body>
  <header class="container-fluid">
      <h1>End</h1>
      <div id="when" hidden><?php echo $_GET['when'];  ?></div>
      <div id="serial" hidden><?php echo $_GET['serial'];  ?></div>
  </header>
  <section id="end" class="container">
    <?php 
      require '../php/connect.php';

      $pdo = Database::connect();
      $row = $pdo -> query('SELECT parc FROM wtg WHERE `serial`="'.$_GET['serial'].'"');
      $parc = $row -> fetch(PDO::FETCH_ASSOC);
      Database::disconnect();
      
      $pdo1 = Database::connect();
      $row = $pdo1 -> query('SELECT tel FROM parc WHERE `nom`="'.$parc['parc'].'"');
      $tel = $row -> fetch(PDO::FETCH_ASSOC);
      Database::disconnect();

      if ($tel['tel']){
    ?>  
        <div>
          <div>For this parc,<span class="alaligne"> you need to call the customer :</span></div>
          <a href="tel:<?php echo $tel['tel'] ?>" id="nTel"><?php echo $tel['tel'] ?></a>
        </div>
    <?php
      } 
      if ($_GET['when']=="in") {
    ?>
        <div>You can start your job !</div>

    <?php
      } elseif ($_GET['when']=="out") {
    ?>
        <div>See you a next time. Bye</div>
    <?php
      }
    ?>
  </section>
  <footer class="container-fluid"><a href="../../index.html">retour</a></footer>
</body>
</html>