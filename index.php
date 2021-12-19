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
  <title>Vestas QR-Code</title>
  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="public/css/style.css">
  <!-- FONT -->
  <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet"> <!-- caveat -->
  <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet"> <!-- Bangers -->
  <!-- SCRIPT -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>
  <header class="container-fluid">
    <h1>Acceuil QR Code</h1>
  </header>

  <?php 
    if (isset($_COOKIE['pwd']) && $_COOKIE['pwd']=='Welcome123'){
  ?>

  <section class="container acceuil">
    <ul>
      <li><a href="public/page/inout.php" class="botn">Générer une entrée/sortie</a></li>
      <li><a href="public/page/listIO.php" class="botn">Liste des entrées/sorties</a></li>
      <li><a href="public/page/wtg.php" class="botn">Liste des WTG</a></li>
      <li><a href="public/page/safety.php" class="botn bg-info">Safety informations</a></li>
      <li><a href="public/page/checkQR.php" class="botn">Check si QR créé</a></li> <!-- bg-info -->
      <li><a href="public/page/users.php" class="botn">Liste des utilisateurs</a></li>
    </ul>
  </section>

  <?php
    }
    else
    {
  ?>
  <form method="POST" action="index.php" id="user-password" enctype="multipart/form-data" class="container">
      <input name="pwd" id="pwd" type="password" placeholder="Password" autocomplete="off">
      <button type="submit" id='pwdGo'>Go</button>
  </form>
  <?php
    }
  ?>

  <footer class="container-fluid" style="font-family: Caveat;">Site créé par M@PiR</footer>
</body>
</html>
