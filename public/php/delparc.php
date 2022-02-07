<?php

require 'connect.php';

if ($_SERVER['REQUEST_METHOD']=="POST"){
  //Supprimer les entrées/sorties en fonction des serials du parc
  $db = Database::connect();
  $resultat = $db -> query('SELECT `serial` FROM `wtg` WHERE `parc` = "'.$_POST['nom'].'"');
  Database::disconnect();
  $listeWTG = $resultat->fetchall(PDO::FETCH_ASSOC);
  foreach ($listeWTG as $wtg){
    $db = Database::connect();
    $db -> query('DELETE FROM `in_out` WHERE `serial` = "'.$wtg['serial'].'"');
    Database::disconnect();
  }
  //Supprimer les machines puis le parc
  $db = Database::connect();
  $db -> query('DELETE FROM `wtg` WHERE `parc` = "'.$_POST['nom'].'"');
  $db -> query('DELETE FROM `parc` WHERE `nom` = "'.$_POST['nom'].'"');
  Database::disconnect();

}

?>