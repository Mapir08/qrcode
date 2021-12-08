<?php

require 'connect.php';

if ($_SERVER['REQUEST_METHOD']=="POST"){
  $db = Database::connect();
  $db -> query('INSERT INTO parc (`nom`, `tel`, `region`, `abreviation`, `client`) VALUES ("'.verif($_POST['nom']).'", "'.verif($_POST['tel']).'", "'.verif($_POST['region']).'", "'.verif($_POST['abv']).'", "'.verif($_POST['client']).'")');
  Database::disconnect();

  $db2 = Database::connect();
  for ($x = 0 ; $x < verif($_POST['nb']) ; $x++){
    $db2 -> query('INSERT INTO wtg (`serial`, `parc`, `pad`) VALUES ('.verif($_POST['serial'.$x]).', "'.verif($_POST['nom']).'", "'.verif($_POST['pad'.$x]).'")');
  }

  Database::disconnect();
}

function verif($var){
  $var=strip_tags($var);
  return $var;
}
?>