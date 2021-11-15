<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vestas QR-Code / Add Turbines</title>
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
    <h1>Ajouter un parc avec ses machines</h1>
  </header>
  <section class="container wtg">
    <div class="wtg_parcadd">
      <form method="get" id="wtg-info" class="wtg_parcadd-info">
        <label for="nom">Nom du Parc *</label><input name="nom" id="nom" type="text" autocomplete="off" value="<?php if($_GET['nom']){echo($_GET['nom']);} ?>">
        <label for="abv">Abreviation</label><input name="abv" id="abv" type="text" autocomplete="off" value="<?php if($_GET['nom']){echo($_GET['abv']);} ?>">
        
        <label for="region">Région d'affiliation *</label>
        <select name="region" id="region">
          <option value=""></option>
          <?php
            require '../php/connect.php'; 
            $db = Database::connect();
            $tempo = $db->query('SELECT `nomRegion` FROM `regions`');
            Database::disconnect();
            while ($row = $tempo->fetch(PDO::FETCH_ASSOC)){
              if ($row['nomRegion']==$_GET['region']){
                echo '<option value="'.$row["nomRegion"].'" selected>'.$row["nomRegion"].'</option>';
              } else {
              echo '<option value="'.$row["nomRegion"].'">'.$row["nomRegion"].'</option>';
              }
            }
          ?>
        </select>

        <label for="np">Nombre WTG *</label><input name="nb" id="nb" type="text" autocomplete="off" value="<?php if($_GET['nb']){echo($_GET['nb']);} ?>">
        <label for="client">Client</label><input name="client" id="client" type="text" autocomplete="off" value="<?php if($_GET['client']){echo($_GET['client']);} ?>">
        <label for="contact">Mail Client</label><input name="contact" id="contact" type="text" autocomplete="off" value="<?php if($_GET['contact']){echo($_GET['contact']);} ?>">
      </form>
      <form method="post" id="wtg-nb" class="wtg_parcadd-wtg">
        <?php
          if ($_GET["nb"]>0) {
            for($x = 0 ; $x < $_GET["nb"] ; $x++){
        ?>
              <div class="ligne">
                <input name="serial<?php echo($x); ?>" id="serial" type="text" placeholder="Serial" autocomplete="off">
                <input name="pad<?php echo($x); ?>" id="pad" type="text" placeholder="N°" autocomplete="off">
              </div>
        <?php
            }
        ?>
            <button class="botn">Save</button>
        <?php
          }
        ?>
      </form>
    </div>
  </section>
  
  <footer class="container-fluid"><a href="wtg.php">retour</a></footer>
</body>
</html>