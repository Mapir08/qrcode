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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>
  <header class="container-fluid">
    <h1>Vérification si QR-Code Créé</h1>
  </header>
  <?php 
    require '../php/connect.php';
  ?>
  <section class="container checkQR">
    <h3>A copier pour la creation du QR-Code</h3>
    <p>https://qr.mapir.net/public/page/inout.php?sn=</p>

  </section>
  
  <footer class="container-fluid"><a href="../../index.html">retour</a></footer>
</body>
</html>