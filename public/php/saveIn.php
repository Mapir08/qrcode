<?php

require 'connect.php';

$confirm = array(
  'tech' => true,
  'detail' => true,
  'date' => true,
  'tel' => false,
  'company' => false,
  'listetelephone' => ''
);
$date = "";
$heure = "";
$arret = "";

$tech1 = verif($_POST['t1']);
$detail = verif($_POST['detail']);
$pauseO_N = verif($_POST['pauseO_N']);
$stopDate = verif($_POST['stopDate']);
$stopHour = verif($_POST['stopHour']);
$telephone = verif($_POST['telephone']);
$company = verif($_POST['company']);

if ($_SERVER['REQUEST_METHOD']=="POST"){

  if (!$tech1) {$confirm['tech']=false;}
  if (!$detail) {$confirm['detail']=false;}
  if ($pauseO_N == 'checked') {
    $arret="oui";
    if (!$stopDate || !$stopHour) {
      $confirm['date']=false;
    }
  } else {
    $arret="non";
    $confirm['date']=true;
  }

  if ($telephone==""){
    $confirm['tel']=false;
  } else {
    $confirm['tel']=true;
  }
  if ($company==""){
    $confirm['company']=false;
  } else {
    $confirm['company']=true;
  }
  $pdo = Database::connect();
  $tel = $pdo -> query('SELECT initial, tel, company FROM user');
  $confirm['listetelephone'] = $tel -> fetchall(PDO::FETCH_ASSOC);
  foreach ($confirm['listetelephone'] as $value){
    if ($value['initial'] == $tech1){
      $confirm['tel']=true;
      $_POST['telephone'] = $value['tel'];
      $confirm['company']=true;
      $_POST['company'] = $value['company'];
    };
  }
  if ($confirm['tech'] && $confirm['detail'] && $confirm['date'] && $confirm['tel'] && $confirm['company']) {
    $db = Database::connect();
    if ($arret == "oui"){
      $db -> query('INSERT INTO `in_out`(`serial`, `pauseO_N`, `in`, `initial1`, `tel`, `company`, `initial2`, `initial3`, `SO`, `details`, `date_pause`, `heure_pause`) VALUES ("'.verif($_POST['serial']).'","oui",NOW(),"'.$tech1.'","'.$telephone.'", "'.$company.'", "'.verif($_POST['t2']).'","'.verif($_POST['t3']).'","'.verif($_POST['so']).'","'.$detail.'","'.$stopDate.'","'.$stopHour.'")');
    } elseif ($arret == "non"){
      $db -> query('INSERT INTO `in_out`(`serial`, `pauseO_N`, `in`, `initial1`, `tel`, `company`, `initial2`, `initial3`, `SO`, `details`) VALUES ("'.verif($_POST['serial']).'","non",NOW(),"'.$tech1.'","'.$telephone.'", "'.$company.'", "'.verif($_POST['t2']).'","'.verif($_POST['t3']).'","'.verif($_POST['so']).'","'.$detail.'")');
    }
    Database::disconnect();
    include ('sendMailIn.php');
  }

  
  echo json_encode($confirm);
}

function verif($var){
  $var=strip_tags($var);
  return $var;
}
?>