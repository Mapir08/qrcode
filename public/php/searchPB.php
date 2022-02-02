<?php

require '../php/connect.php';

$listeOK = array(
  'pbLift' => "",
  'pbRaiEch' => "",
  'pbExc' => "",
  'pbCrane' => "",
  'pbResq' => ""
);

if ($_SERVER['REQUEST_METHOD']=="POST"){
  $db = Database::connect();
  $liste = $db->query('SELECT `pbLift`, `pbRaiEch`, `pbExc`, `pbCrane`, `pbResq` FROM `wtg` WHERE `serial`="'.$_POST['serial'].'"');
  Database::disconnect();

  $listeFetch = $liste->fetch(PDO::FETCH_ASSOC);

  $listeOK['pbLift'] = $listeFetch['pbLift'];
  $listeOK['pbRaiEch'] = $listeFetch['pbRaiEch'];
  $listeOK['pbExc'] = $listeFetch['pbExc'];
  $listeOK['pbCrane'] = $listeFetch['pbCrane'];
  $listeOK['pbResq'] = $listeFetch['pbResq'];

  echo json_encode($listeOK);
}

?>