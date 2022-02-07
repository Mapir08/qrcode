<?php

require 'connect.php';

if ($_SERVER['REQUEST_METHOD']=="POST"){ // Ouvert via la méthode POST du formulaire

  $db = Database::connect();
  $db -> query('INSERT INTO regions (`nomRegion`, `contact`) VALUES ("'.verif($_POST['nom']).'", "'.verif($_POST['manager']).'")');
  Database::disconnect();

}

function verif($var){
  $var=strip_tags($var); // retire toutes les balises qui auraient pu être entré par malveillance
  return $var;
}
?>