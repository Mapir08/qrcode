<?php

require 'connect.php';

if ($_SERVER['REQUEST_METHOD']=="POST"){ // Ouvert via la méthode POST du formulaire

  $db = Database::connect();
  $db -> query('INSERT INTO user (`initial`, `Nom`, `Prenom`, `tel`, `region`) VALUES ("'.verif($_POST['initial']).'", "'.verif($_POST['nom']).'", "'.verif($_POST['prenom']).'", '.verif($_POST['tel']).', "'.verif($_POST['region']).'")');
  Database::disconnect();

}

function verif($var){
  $var=strip_tags($var); // retire toutes les balises qui auraient pu être entré par malveillance
  return $var;
}
?>