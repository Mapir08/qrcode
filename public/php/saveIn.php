<?php

require 'connect.php';

$confirm = array(
  'tech' => true,
  'so' => true,
  'detail' => true,
  'date' => true
);
$date="";
$heure="";
$arret="";


if ($_SERVER['REQUEST_METHOD']=="POST"){

  if (!verif($_POST['t1'])) {$confirm['tech']=false;}
  if (!verif($_POST['so'])) {$confirm['so']=false;}
  if (!verif($_POST['detail'])) {$confirm['detail']=false;}

  if (verif($_POST['pauseO_N']) == 'checked') {
    $arret="oui";
    if (!verif($_POST['stopDate']) || !verif($_POST['stopHour'])) {
      $confirm['date']=false;
    }
  } else {
    $arret="non";
    $confirm['date']=true;
  }

  if ($confirm['tech'] && $confirm['so'] && $confirm['detail'] && $confirm['date']) {
    $db = Database::connect();
    if ($arret == "oui"){
      $db -> query('INSERT INTO `in_out`(`serial`, `pauseO_N`, `date_pause`, `heure_pause`, `in`, `initial1`, `initial2`, `initial3`, `SO`, `details`) VALUES ("'.verif($_POST['serial']).'","'.$arret.'","'.verif($_POST['stopDate']).'","'.verif($_POST['stopHour']).'",NOW(),"'.verif($_POST['t1']).'","'.verif($_POST['t2']).'","'.verif($_POST['t3']).'","'.verif($_POST['so']).'","'.verif($_POST['detail']).'")');
    } elseif ($arret == "non"){
      $db -> query('INSERT INTO `in_out`(`serial`, `pauseO_N`, `in`, `initial1`, `initial2`, `initial3`, `SO`, `details`) VALUES ("'.verif($_POST['serial']).'","'.$arret.'",NOW(),"'.verif($_POST['t1']).'","'.verif($_POST['t2']).'","'.verif($_POST['t3']).'","'.verif($_POST['so']).'","'.verif($_POST['detail']).'")');
    }
    Database::disconnect();
  }

  echo json_encode($confirm);
}

function verif($var){
  $var=strip_tags($var); // retire toutes les balises qui auraient pu être entré par malveillance
  return $var;
}

?>