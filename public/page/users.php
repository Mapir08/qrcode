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
  <title>Vestas QR-Code / Utilisateurs</title>
  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
  <!-- FONT -->
  <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet"> <!-- caveat -->
  <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet"> <!-- Bangers -->
  <!-- SCRIPT -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="../js/user.js"></script>
</head>
<body>
  <header class="container-fluid">
    <h1>Listes des utilisateurs</h1>
  </header>

  <?php
    require '../php/connect.php';
    if (isset($_COOKIE['pwd']) && $_COOKIE['pwd']=='Welcome123'){
  ?>

  <section class="container user">
    <div class="user_entete">
      <div class="user_initial">Initiale</div>
      <div class="user_nom">Nom</div>
      <div class="user_prenom">Prénom</div>
      <div class="user_tel">Tél</div>
      <div class="user_company">Compagnie</div>
      <div class="user_del"></div>
    </div>
    <section class="user_add">
      <form method="post" id="user-add">
        <div class="user_initial"><input name="initial" id="initial" type="text" class="adduser_initial" autocomplete="off"></div>
        <input name="nom" id="nom" type="text" class="adduser_nom" autocomplete="off">
        <input name="prenom" id="prenom" type="text" class="adduser_prenom" autocomplete="off">
        <input name="tel" id="tel" type="text" class="adduser_tel" autocomplete="off">
        <input name="company" id="company" class="adduser_company" autocomplete="off">
        <button type="submit">Add</button>
      </form>
    </section>
    <?php
        $db = Database::connect();
        $tempo = $db->query('SELECT `initial`,`Nom`,`Prenom`,`tel`,`company` FROM `user`');
        Database::disconnect();
        while ($row = $tempo->fetch(PDO::FETCH_ASSOC)){
          echo '<div class="user_ligne">
                  <div class="user_initial">'.$row["initial"].'</div>
                  <div class="user_nom">'.$row["Nom"].'</div>
                  <div class="user_prenom">'.$row["Prenom"].'</div>
                  <div class="user_tel">'.$row["tel"].'</div>
                  <div class="user_company">'.$row["company"].'</div>
                  <div class="user_del"><span>x</span></div>
                </div>';
        }
      ?>
  </section>

  <footer class="container-fluid"><a href="../../index.php">retour</a></footer>
  <?php
    }
    else
    {
  ?>
  <form method="POST" action="users.php" id="user-password" enctype="multipart/form-data" class="container">
      <input name="pwd" id="pwd" type="password" placeholder="Password" autocomplete="off">
      <button type="submit" id='pwdGo'>Go</button>
  </form>
  <?php
    }
  ?>

</body>
</html>