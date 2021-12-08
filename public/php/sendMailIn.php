<?php

    $db = Database::connect();
    $resultat = $db -> query('SELECT parc, pad FROM wtg WHERE `serial`="'.verif($_POST['serial']).'"');
    Database::disconnect();
    $infoParc = $resultat -> fetch(PDO::FETCH_ASSOC);

    $db = Database::connect();
    $resultat =  $db -> query('SELECT abreviation FROM parc WHERE `nom`="'.$infoParc['parc'].'"');
    Database::disconnect();
    $infoAbrev = $resultat -> fetch(PDO::FETCH_ASSOC);

    $db = Database::connect();
    $resultat =  $db -> query('SELECT `company` FROM `user` WHERE `initial`="'.verif($_POST['t1']).'"');
    Database::disconnect();
    $infoCompany = $resultat -> fetch(PDO::FETCH_ASSOC);

$stopped = "";
if($arret=="oui"){
  $stopped="Y";
}else{
  $stopped="N";
}

$stopDate = date_format(new DateTime($stopDate), 'd/m/Y');

if(verif($_POST['company']) != ""){
  $resultat2['company'] = $_POST['company'];
}

$to = "math.perlier@gmail.com";
$subject = "IN_TURBINE_".verif($_POST['serial'])."_".$infoAbrev['abreviation']."_".$infoParc['pad'];

$message = "";
$message .= "TURBINE ID: ".verif($_POST['serial'])."\n";
$message .= "WINDFARM: ".$infoAbrev['abreviation']."_".$infoParc['pad']." \n";
$message .= "STIE_WTG_IN \n";
$message .= "COMPANY: ".$infoCompany['company']."\n";
$message .= "TECH1: ".verif($_POST['t1'])."\n";
$message .= "TECH2: ".verif($_POST['t2'])."\n";
$message .= "TECH3: ".verif($_POST['t3'])."\n";
$message .= "OPERATION: ".$detail."\n";
$message .= "REQUIRED STOP (Y/N): ".$stopped."\n";
$message .= "WTG STOP DATE (dd/mm/yyyy): ".$stopDate."\n";
$message .= "WTG STOP TIME (hh:mm): ".$stopHour."\n";
$message .= "SERVICE ORDER (OPTIONAL): ".verif($_POST['so'])."\n";

mail($to, $subject, $message);

?>