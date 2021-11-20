<?php

require 'connect.php';

if ($_SERVER['REQUEST_METHOD']=="POST"){
  $pdo = Database::connect();
  $resultat = $pdo -> query('SELECT `serial` FROM `wtg` WHERE parc="'.verif($_POST['parc']).'" AND pad="'.verif($_POST['pad']).'"');
  Database::disconnect();

  $sn=$resultat->fetch(PDO::FETCH_NUM);

  echo($sn[0]);
}

function verif($var){
  $var=strip_tags($var); // retire toutes les balises qui auraient pu être entré par malveillance
  return $var;
}
?>