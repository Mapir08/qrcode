<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vestas QR-Code / Listing</title>
  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
  <!-- FONT -->
  <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet"> <!-- caveat -->
  <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet"> <!-- Bangers -->
  <!-- SCRIPT -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="../js/listeIO.js"></script>
</head>
<body>
  <header class="container-fluid">
    <h1>Listes des entrées / sorties</h1>
  </header>

  <?php
    require '../php/connect.php';

    $db = Database::connect();
    $in_out = $db->query('SELECT * FROM `in_out`');
    Database::disconnect();
  ?>

  <section class="container" id="listIO">
    <div class="selecteur">
      <select name="region" class="botn" id="region">
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
      <select name="parc" class="botn" id="parc" disabled>
        <option id="allParcs" value="" selected>Parcs</option>
        <?php
          $db = Database::connect();
          $tempo = $db->query('SELECT wtg.parc as `parc` FROM `in_out` INNER JOIN `wtg` ON in_out.serial = wtg.serial GROUP BY wtg.parc');
          Database::disconnect();
          while ($row = $tempo->fetch(PDO::FETCH_ASSOC)){
            echo '<option id="'.str_replace(" " ,"_",$row["parc"]).'" value="'.$row["parc"].'">'.$row["parc"].'</option>';
          }
        ?>
      </select>
      <button class="botn" id="onsite" disabled>Sur site ?</button>
    </div>

    <?php
      $db = Database::connect();
      $tempo = $db->query('SELECT wtg.parc AS parc, wtg.pad AS pad, `in`, `out`, in_out.tel AS telAdd, user.tel AS telUser, in_out.company AS companyAdd, user.company AS companyUser, `initial1`, `initial2`, `initial3`, `details`, `cr`, parc.region, date_pause, heure_pause, date_run, heure_run FROM `in_out` LEFT JOIN `wtg` ON (in_out.serial = wtg.serial) LEFT JOIN `user` ON (in_out.initial1 = user.initial) LEFT JOIN `parc` ON (wtg.parc = parc.nom) ORDER BY in_out.in DESC');
      Database::disconnect();
      while ($row = $tempo->fetch(PDO::FETCH_ASSOC)){
        $IN = $OUT = $pauseD = $pauseH = $runD = $runH = "";
        if ($row['in']) {
          $IN = date_format(date_create($row['in']), 'd/m/Y - h\hm');
        }
        if ($row['out']) {
          $OUT = date_format(date_create($row['out']), 'd/m/Y - h\hm');
        }else{
          $OUT = "en cours";
        }
        if ($row['date_pause']) {
          $pauseD = 'Pause : '.date_format(date_create($row['date_pause']), 'd/m/y');
        }
        if ($row['heure_pause']) {
          $pauseH = ' à '.date_format(date_create($row['heure_pause']), 'h\hm');
        }
        if ($row['date_run']) {
          $runD = ' _ Run : '.date_format(date_create($row['date_run']), 'd/m/y');
        }
        if ($row['heure_run']) {
          $runH = ' à '.date_format(date_create($row['heure_run']), 'h\hm');
        }
        echo '<div class="intervention">
                <div class="ligne">
                  <div class="region" hidden>'.$row['region'].'</div>
                  <div class="parc">'.$row['parc'].'</div>
                  <div class="pad">'.$row['pad'].'</div>
                  <div class="company">'.$row['companyAdd'].$row['companyUser'].'</div>
                  <div class="date">
                    <div>'.$IN.'</div>
                    <div>'.$OUT.'</div>
                  </div>
                </div>
                <div class="ligne">
                  <div class="tech">
                    <div class="t1">'.$row['initial1'].'</div>
                    <div class="t2">'.$row['initial2'].'</div>
                    <div class="t3">'.$row['initial3'].'</div>
                  </div>
                  <div class="tel">'.$row['telUser'].$row['telAdd'].'</div>
                  <div class="detail">
                    <div class="titre">'.$row['details'].'</div>
                    <div class="cr">'.$row['cr'].'</div>
                    <div class="pause_run">'.$pauseD.$pauseH.$runD.$runH.'</div>
                  </div>
                </div>
              </div>';
      }
    ?>

  <footer class="container-fluid"><a href="../../index.php">retour</a></footer>
</body>
</html>