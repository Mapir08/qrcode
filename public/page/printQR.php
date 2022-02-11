<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vestas QR-Code / In & Out</title>
  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../css/style.css">
  <!-- SCRIPT -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="../js/print.js"></script>
</head>
<body>
  <header class="container-fluid">
    <h1>Imprimer les QR Codes</h1>
  </header>

  <?php
    require '../php/connect.php';
  ?>
  
  <form method="post" class="container" id="print">
    <p>
      <b>Lorsque la fenêtre d'impression s'ouvrira : </b><br>
      - Vérifier à ce que les QR Codes soient créés <br>
      - Imprimer en A5 pour une bonne mise en page
    </p>
    <select name="parc" class="botn" id="parc">
      <option value="" selected disabled>Parcs</option>
      <?php
        $db = Database::connect();
        $tempo = $db->query('SELECT `nom` FROM `parc`');
        Database::disconnect();
        while ($row = $tempo->fetch(PDO::FETCH_ASSOC)){
          echo '<option value="'.$row["nom"].'" name="'.$row["nom"].'">'.$row["nom"].'</option>';
        }
      ?>
    </select>
    <button id="printBtn">Print</button>
  </form>

  <div id="printArea">
  </div>

  <footer class="container-fluid"><a href="../../index.php">retour</a></footer>
</body>
</html>