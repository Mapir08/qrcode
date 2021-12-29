<form methode="POST" id="inoutQR">

  <?php

    function verif($var){
      $var=strip_tags($var);
      return $var;
    }

    // Controle si le SN est existant :
    $pdo = Database::connect();
    $resultat = $pdo -> query('SELECT parc,pad FROM wtg WHERE serial="'.verif($_GET['sn']).'"');
    Database::disconnect();
    $sn=$resultat->fetch(PDO::FETCH_NUM);

    if($sn){
      // pour le IN
      $pdo = Database::connect();
      $resultat = $pdo -> query('SELECT `dateInspLift`, `dateInspRaiEchExc`, `dateInspCrane`, `dateValidResq`, `pbLift`, `pbRaiEch`, `pbExc`, `pbCrane`, `pbResq` FROM `wtg` WHERE `serial`="'.verif($_GET['sn']).'"');
      Database::disconnect();
      $inSafety = $resultat->fetch(PDO::FETCH_ASSOC);

      // pour le OUT
      $pdo = Database::connect();
      $resultat = $pdo -> query('SELECT `id`, `serial`, `pauseO_N`, `date_pause`, `heure_pause`, `in`, `details` FROM `in_out` WHERE `serial`="'.verif($_GET['sn']).'" AND `out` IS NULL');
      Database::disconnect();
      $in_out = $resultat->fetch(PDO::FETCH_ASSOC);

      if ($in_out){
        $IO = "OUT";
      }else{
        $IO = "IN";
      }

      // Début test SAFETY
      $safetyOk = true ;
      $dateToday = date('d/m/Y') ;
      $dateLift = date_format(date_create($inSafety['dateInspLift']), 'd/m/Y') ;
      $dateRailEch = date_format(date_create($inSafety['dateInspRaiEchExc']), 'd/m/Y') ;
      $dateCrane = date_format(date_create($inSafety['dateInspCrane']), 'd/m/Y') ;
      $dateResq = date_format(date_create($inSafety['dateValidResq']), 'd/m/Y') ;
      if ($dateLift < $dateToday || $dateRailEch < $dateToday || $dateCrane < $dateToday || $dateResq < $dateToday) {
        $safetyOk = false;
      }
      if ($inSafety['pbLift']=='oui' || $inSafety['pbLift']==NULL || $inSafety['pbRaiEch']=='oui' || $inSafety['pbRaiEch']==NULL || $inSafety['pbCrane']=='oui' || $inSafety['pbCrane']==NULL || $inSafety['pbExc']=='oui' || $inSafety['pbExc']==NULL || $inSafety['pbResq']=='oui' || $inSafety['pbResq']==NULL) {
        $safetyOk = false;
      }
      $imgState = ($safetyOk) ? 'imgState-ok' : 'imgState-nok';
      // Fin test SAFETY

      if ($IO == "IN"){
  ?>
        <div class="entete">
          <div class="io" id="io"><?php echo($IO); ?></div>
          <div class="description"><?php echo($sn[0]); ?> <?php echo($sn[1]); ?><span id="tiret"> - </span><span id="serial"><?php echo($_GET['sn']) ?></span></div>
        </div>
        <div class="imgState <?php echo($imgState) ?>" id="state"></div>
        <div class="safety" id="postit">
          <div class="safety-lift">
            <span>Date Lift : </span>
            <span <?php echo(($dateLift < $dateToday) ? 'class="error"' : ''); ?>><?php echo($dateLift); ?></span>
            <span <?php echo(($inSafety['pbLift']=='oui' || $inSafety['pbLift']==NULL) ? 'class="error"' : ''); ?>><?php echo(($inSafety['pbLift']=='oui' || $inSafety['pbLift']==NULL) ? 'Not Ok' : 'Ok'); ?></span>
          </div>
          <div class="safety-RE">
            <span>Date Rail/Echelle : </span>
            <span <?php echo(($dateRailEch < $dateToday) ? 'class="error"' : ''); ?>><?php echo($dateRailEch); ?></span>
            <span <?php echo(($inSafety['pbRaiEch']=='oui' || $inSafety['pbRaiEch']==NULL) ? 'class="error"' : ''); ?>><?php echo(($inSafety['pbRaiEch']=='oui' || $inSafety['pbRaiEch']==NULL) ? 'Not Ok' : 'Ok'); ?></span>
          </div>
          <div class="safety-crane">
            <span>Date Crane : </span>
            <span <?php echo(($dateCrane < $dateToday) ? 'class="error"' : ''); ?>><?php echo($dateCrane); ?></span>
            <span <?php echo(($inSafety['pbCrane']=='oui' || $inSafety['pbCrane']==NULL) ? 'class="error"' : ''); ?>><?php echo(($inSafety['pbCrane']=='oui' || $inSafety['pbCrane']==NULL) ? 'Not Ok' : 'Ok'); ?></span>
          </div>
          <div class="safety-ext">
            <span>Date Extincteur : </span>
            <span <?php echo(($dateRailEch < $dateToday) ? 'class="error"' : ''); ?>><?php echo($dateRailEch); ?></span>
            <span <?php echo(($inSafety['pbExc']=='oui' || $inSafety['pbExc']==NULL) ? 'class="error"' : ''); ?>><?php echo(($inSafety['pbExc']=='oui' || $inSafety['pbExc']==NULL) ? 'Not Ok' : 'Ok'); ?></span>
          </div>
          <div class="safety-resq">
            <span>Date RESQ : </span>
            <span <?php echo(($dateResq < $dateToday) ? 'class="error"' : ''); ?>><?php echo($dateResq); ?></span>
            <span <?php echo(($inSafety['pbResq']=='oui' || $inSafety['pbResq']==NULL) ? 'class="error"' : ''); ?>><?php echo(($inSafety['pbResq']=='oui' || $inSafety['pbResq']==NULL) ? 'Not Ok' : 'Ok'); ?></span>
          </div>
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
            <input type="text" name="telephone" id="telephone" autocomplete="off" placeholder="Tel" inputmode="numeric" hidden>
            <input type="text" name="company" id="company" autocomplete="off" placeholder="Company" hidden>
          </div>
        </div>
        <div class="so"><label for="so">SO</label><input type="text" name="so" id="so" autocomplete="off" inputmode="numeric"></div>
        <div class="detail"><label for="detail">Motif</label><input type="text" name="detail" id="detail" autocomplete="off"></div>
        <button class="send" id="sendIN">Send</button>
  <?php
      }elseif ($IO=="OUT"){
  ?>
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