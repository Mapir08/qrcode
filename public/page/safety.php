<?php
  if (isset($_POST['pwd'])){
    setcookie("pwd", $_POST['pwd'], time()+3600);
    header("Refresh:0");
  }
?>

!DOCTYPE html>
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
  <!-- <script src="../js/safety.js"></script> -->
</head>
<body>
  <header class="container-fluid">
      <h1>Safety inspection date</h1>
  </header>

  <?php 
    require '../php/connect.php';
    if (isset($_COOKIE['pwd']) && $_COOKIE['pwd']=='Welcome123'){
  ?>

  <section id="safety">

  </section>

  <?php
    }
    else
    {
  ?>
  <form method="POST" action="safety.php" id="user-password" enctype="multipart/form-data" class="container">
      <input name="pwd" id="pwd" type="password" placeholder="Password" autocomplete="off">
      <button type="submit" id='pwdGo'>Go</button>
  </form>
  <?php
    }
  ?>
  
  <footer class="container-fluid"><a href="../../index.php">retour</a></footer>
</body>
</html>
