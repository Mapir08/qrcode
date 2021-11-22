<form methode="POST" id="inoutQR">

  <?php

    function verif($var){
      $var=strip_tags($var); // retire toutes les balises qui auraient pu être entré par malveillance
      return $var;
    }

    // Controle si le SN est existant :
    $pdo = Database::connect();
    $resultat = $pdo -> query('SELECT parc,pad FROM wtg WHERE serial="'.verif($_GET['sn']).'"');
    Database::disconnect();
    $sn=$resultat->fetch(PDO::FETCH_NUM);

    if($sn){
      $pdo = Database::connect();
      $resultat1 = $pdo -> query('SELECT `serial`, `pauseO_N`, `date_pause`, `heure_pause`, `in`, `date_run`, `heure_run`, `out`, `initial1`, `tel1`, `initial2`, `tel2`, `initial3`, `tel3`, `SO`, `details`, `cr` FROM `in_out` WHERE `serial`="'.verif($_GET['sn']).'" AND `out` IS NULL');
      Database::disconnect();
      $in_out = $resultat1->fetch(PDO::FETCH_ASSOC);
      if ($in_out){ // Si une ligne dans la recherche est trouvé => c'est qu'on va faire le OUT, sinon c'est qu'on est sur le IN
        $IO = "OUT";
      }else{
        $IO = "IN";
      }
      // Si IN : 
      if ($IO == "IN"){
  ?>
        <div class="entete">
          <div id="io"><?php echo($IO); ?></div>
          <div><?php echo($sn[0]); ?> <?php echo($sn[1]); ?> - <span id="serial"><?php echo($_GET['sn']) ?></span></div>
        </div>
        <div><label for="pauseO_N">Stop needed ? </label><input type="checkbox" id="pauseO_N" name="pauseO_N" checked></div>
        <!-- Dates/Heures pause WTG -->
        <div><label for="stopDate">Turbine Stop :</label><input type="date" name="stopDate" id="stopDate" autocomplete="off"><input type="time" name="stopHour" id="stopHour" autocomplete="off"></div>
        <!-- Intervenants -->
        <div><label for="t1">Tech 1 :</label><input type="text" name="t1" id="t1" autocomplete="off"></div>
        <div><label for="t2">Tech 2 :</label><input type="text" name="t2" id="t2" autocomplete="off"></div>
        <div><label for="t3">Tech 3 :</label><input type="text" name="t3" id="t3" autocomplete="off"></div>
        <!-- Description -->
        <div><label for="so">SO :</label><input type="text" name="so" id="so" autocomplete="off"></div>
        <div><label for="detail">Détail :</label><input type="text" name="detail" id="detail" autocomplete="off"></div>
        <button>Send</button>
  <?php
      }elseif ($IO=="OUT"){
  ?>
        <div><?php echo($IO); ?></div>
        <!-- Dates/Heures run WTG -->
        <!-- Si pauseO_N = "non" ne pas afficher les dates/heures de run -->
        <div><label for="runDate">Trubine Run :</label><input type="date" name="startDate" id="startDate" autocomplete="off"><input type="time" name="startHour" id="startHour" autocomplete="off"></div>
        <!-- Description -->
        <div><label for="cr">Compte rendu :</label><textarea name="cr" id="cr" cols="50" rows="2"></textarea></div>
  <?php
      }
    }else{
  ?>
      Numéro de série non reconnu
  <?php
    }
  ?>
</form>