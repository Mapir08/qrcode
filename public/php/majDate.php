<?php

require '../php/connect.php';

if ($_POST['majVersion'] = 1 ){
  $serial = $_POST['serial'];
  $newDate = $_POST['date'];
  switch ($_POST['equipement']){
    case "Lift": 
      $equipement = 'dateInspLift';
      break;
    case "RailEchelle":
      $equipement = 'dateInspRaiEchExc';
      break;
    case "Extincteur":
      $equipement = 'dateInspRaiEchExc';
      break;
    case "Crane":
      $equipement = 'dateInspCrane';
      break;
    case "ResQ":
      $equipement = 'dateValidResq';
      break;
  }
  $db = Database::connect(); 
  $db -> query('UPDATE wtg SET '.$equipement.'="'.$newDate.'" WHERE `serial`='.$serial);
  Database::disconnect();

} else if ($_POST['majVersion'] = 2 ){

}

?>