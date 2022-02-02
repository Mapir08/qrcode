<?php

require '../php/connect.php';


if ($_SERVER['REQUEST_METHOD']=="POST"){
  $db = Database::connect();
  if (isset($_POST['type'])) {
    $date=$_POST['date'];
    if ($_POST['type'] == "lift"){
      $liste = $db->query('UPDATE `wtg` SET `pbLift`="'.$_POST['lift'].'",`pbRaiEch`="'.$_POST['RE'].'",`pbExc`="'.$_POST['exct'].'",`pbCrane`="'.$_POST['crane'].'",`pbResq`="'.$_POST['resq'].'", `dateInspLift`="'.$date.'" WHERE `serial`="'.$_POST['serial'].'"');
    } else if ($_POST['type'] == "complet"){
      $liste = $db->query('UPDATE `wtg` SET `pbLift`="'.$_POST['lift'].'",`pbRaiEch`="'.$_POST['RE'].'",`pbExc`="'.$_POST['exct'].'",`pbCrane`="'.$_POST['crane'].'",`pbResq`="'.$_POST['resq'].'", `dateInspLift`="'.$date.'", `dateInspRaiEchExc`="'.$date.'", `dateInspCrane`="'.$date.'", `dateValidResq`="'.$date.'" WHERE `serial`="'.$_POST['serial'].'"');
    }
  } else {
    $liste = $db->query('UPDATE `wtg` SET `pbLift`="'.$_POST['lift'].'",`pbRaiEch`="'.$_POST['RE'].'",`pbExc`="'.$_POST['exct'].'",`pbCrane`="'.$_POST['crane'].'",`pbResq`="'.$_POST['resq'].'" WHERE `serial`="'.$_POST['serial'].'"');
  }
  Database::disconnect();
}

?>