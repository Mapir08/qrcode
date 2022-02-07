<?php

require 'connect.php';

if ($_SERVER['REQUEST_METHOD']=="POST"){

  $db = Database::connect();
  $db -> query('DELETE FROM `regions` WHERE `nomRegion` = "'.$_POST['nom'].'"');
  Database::disconnect();

}

?>