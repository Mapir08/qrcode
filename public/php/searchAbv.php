<?php

require 'connect.php';

if ($_SERVER['REQUEST_METHOD']=="POST"){
  $pdo = Database::connect();
  $resultat = $pdo -> query('SELECT `abreviation` FROM `parc` WHERE nom="'.$_POST['nom'].'"') or die (print_r($pdo->errorInfo()));
  Database::disconnect();

  $abv=$resultat->fetch(PDO::FETCH_ASSOC);

  echo($abv['abreviation']);
}

?>