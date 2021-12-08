<?php

require 'connect.php';

$confirm = array(
  'date' => true,
  'cr' => true
);

$id = verif($_POST['id']);
$paused = verif($_POST['paused']);
$date = verif($_POST['startDate']);
$hour = verif($_POST['startHour']);
$runO_N = verif($_POST['runO_N']);
$cr = verif($_POST['cr']);


if ($_SERVER['REQUEST_METHOD']=="POST"){

  if ($cr == "") {
    $confirm['cr'] = false;
  }
  
  if ($paused == "non"){
    $confirm['date'] = true;
    date_default_timezone_set('Europe/Paris');
    $date = date('Y-m-d');
    $hour = date('H:i');
    $runO_N = "N/A";
  } elseif ($paused == "oui" && $runO_N == "oui" && !$date =="" && !$date =="" ) {
    $confirm['date'] = true;
  } elseif ($paused == "oui" && $runO_N == "non"){
    date_default_timezone_set('Europe/Paris');
    $date = date('Y-m-d');
    $hour = date('H:i');
    $confirm['date'] = true;
  } elseif ($paused == "oui" && ($runO_N == "oui" && ($date =="" || $hour ==""))) {
    $confirm['date'] = false;
  }

  if ($confirm['date'] && $confirm['cr']){
    $db = Database::connect(); 
    // $db -> query('UPDATE in_out SET date_run="'.$date.'" ,heure_run="'.$hour.'" ,cr="'.$cr.'" , runO_N="'.$runO_N.'", `out`=NOW() WHERE id='.$id);
    Database::disconnect();
    include ('sendMailOut.php');
  }
  echo json_encode($confirm);
}

function verif($var){
  $var=strip_tags($var);
  return $var;
}
?>