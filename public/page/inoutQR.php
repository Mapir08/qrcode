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
      $resultat1 = $pdo -> query('SELECT `id`, `serial`, `pauseO_N`, `date_pause`, `heure_pause`, `in`, `details` FROM `in_out` WHERE `serial`="'.verif($_GET['sn']).'" AND `out` IS NULL');
      Database::disconnect();
      $in_out = $resultat1->fetch(PDO::FETCH_ASSOC);
      if ($in_out){ // Si une ligne dans la recherche est trouvé => c'est qu'on va faire le OUT, sinon c'est qu'on est sur le IN
        $IO = "OUT";
      }else{
        $IO = "IN";
      }

      if ($IO == "IN"){
  ?>
        <div class="entete">
          <div class="io" id="io"><?php echo($IO); ?></div>
          <div class="description"><?php echo($sn[0]); ?> <?php echo($sn[1]); ?><span id="tiret"> - </span><span id="serial"><?php echo($_GET['sn']) ?></span></div>
        </div>
        <div class="form-check form-switch">
          <label for="pauseO_N" class="form-check-label">Stop needed :</label>
          <input type="checkbox" id="pauseO_N" name="pauseO_N" class="form-check-input" checked>
        </div>
        <div class="dateTime">
          <input type="date" name="stopDate" id="stopDate" autocomplete="off">
          <input type="time" name="stopHour" id="stopHour" autocomplete="off">
        </div>
        <div class="tech">
          <div>
            <div class="label">Tehcnicians</div>
            <div class="input">
              <input type="text" name="t1" id="t1" autocomplete="off">
              <input type="text" name="t2" id="t2" autocomplete="off">
              <input type="text" name="t3" id="t3" autocomplete="off">
            </div>
          </div>
          <div class="tel">
            <input type="text" name="telephone" id="telephone" autocomplete="off" placeholder="Tel" hidden>
            <input type="text" name="company" id="company" autocomplete="off" placeholder="Company" hidden>
          </div>
        </div>
        <div class="so"><label for="so">SO</label><input type="text" name="so" id="so" autocomplete="off"></div>
        <div class="detail"><label for="detail">Détail</label><input type="text" name="detail" id="detail" autocomplete="off"></div>
        <button class="send" id="sendIN">Send</button>
  <?php
      }elseif ($IO=="OUT"){
  ?>
        <!-- Trouver une solution pour passer les valeur 'id' et 'pausO_N' autre qu'en caché-->
        <span id="rowID" hidden><?php echo($in_out['id']) ?></span><span id="paused" hidden><?php echo($in_out['pauseO_N']) ?></span>

        <div class="entete">
          <div class="io" id="io"><?php echo($IO); ?></div>
          <div class="description">
            <div><?php echo($sn[0]); ?> <?php echo($sn[1]); ?><span id="tiret"> - </span><span id="serial"><?php echo($_GET['sn']) ?></span></div>
            <div>
              <?php
                if ($in_out['pauseO_N'] == "non") {
                  echo("Pas d'arrêt machine.");
                }else{
                  $date= date_create($in_out["date_pause"]);
                  $heure= date_create($in_out["heure_pause"]);
                  echo('Paused '),date_format($date, 'd/m/Y'),(' at '),date_format($heure, 'H\hi');
                }
              ?>
              <br/>
              <?php echo($in_out['details']); ?>
            </div>
          </div>
        </div>
        <?php
          if ($in_out['pauseO_N'] == "oui"){
        ?>
          <div class="form-check form-switch">
            <label for="runO_N" class="form-check-label">Run :</label>
            <input type="checkbox" id="runO_N" name="runO_N" class="form-check-input" checked>
          </div>
          <div class="dateTime">
            <input type="date" name="startDate" id="startDate" autocomplete="off">
            <input type="time" name="startHour" id="startHour" autocomplete="off">
          </div>
        <?php
          }
        ?>
          <div class="cr"><label for="cr">Compte rendu :</label><textarea name="cr" id="cr" cols="50" rows="2"></textarea></div>
          <button class="send" id="sendOUT">Send</button>
  <?php
      }
    }else{
  ?>
      Numéro de série non reconnu
  <?php
    }
  ?>
</form>