<?php

require '../php/connect.php';

$parcSelected = $_POST['parc'];

if ($_SERVER['REQUEST_METHOD']=="POST"){
  $pdo = Database::connect();
  $resultat = $pdo -> query('SELECT `serial`, `pad`, `dateInspLift`, `dateInspRaiEchExc`, `dateInspCrane`, `dateValidResq`, `pbLift`, `pbRaiEch`, `pbExc`, `pbCrane`, `pbResq` FROM `wtg` WHERE parc="'.$parcSelected.'"');
  Database::disconnect();

  $liste = $resultat->fetchall(PDO::FETCH_ASSOC);

  echo json_encode($liste);
}

?>