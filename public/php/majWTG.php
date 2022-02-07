<?php

require '../php/connect.php';

  $db = Database::connect(); 
  $db -> query('UPDATE parc SET `'.$_POST['type'].'`="'.$_POST['newData'].'" WHERE `nom`="'.$_POST['parc'].'"');
  Database::disconnect();

?>