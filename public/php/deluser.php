<?php

require 'connect.php';

if ($_SERVER['REQUEST_METHOD']=="POST"){

  $db = Database::connect();
  $db -> query('DELETE FROM `user` WHERE `initial` = "'.$_POST['nom'].'"');
  Database::disconnect();

}

?>