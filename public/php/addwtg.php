<?php

require 'connect.php';

if ($_SERVER['REQUEST_METHOD']=="POST"){
  $db = Database::connect();
  $db -> query('INSERT INTO parc (`nom`, `client`, `contact`, `region`, `abreviation`) VALUES ("'.verif($_POST['nom']).'", "'.verif($_POST['client']).'", "'.verif($_POST['contact']).'", "'.verif($_POST['region']).'", "'.verif($_POST['abv']).'")');
  Database::disconnect();

  $db2 = Database::connect();
  for ($x = 0 ; $x < verif($_POST['nb']) ; $x++){
    $db2 -> query('INSERT INTO wtg (`serial`, `parc`, `pad`) VALUES ('.verif($_POST['serial'.$x]).', "'.verif($_POST['nom']).'", "'.verif($_POST['pad'.$x]).'")');
  }

  Database::disconnect();
}

function verif($var){
  $var=strip_tags($var); // retire toutes les balises qui auraient pu être entré par malveillance
  return $var;
}
?>