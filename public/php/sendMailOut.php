<?php

    $db = Database::connect();
    $resultat = $db -> query('SELECT `serial`, pauseO_N, initial1, initial2, initial3, SO, company FROM in_out WHERE id="'.verif($_POST['id']).'"');
    Database::disconnect();
    $infoLigne = $resultat -> fetch(PDO::FETCH_ASSOC);

    $db = Database::connect();
    $resultat = $db -> query('SELECT parc, pad FROM wtg WHERE `serial`="'.$infoLigne['serial'].'"');
    Database::disconnect();
    $infoParc = $resultat -> fetch(PDO::FETCH_ASSOC);

    $db = Database::connect();
    $resultat =  $db -> query('SELECT abreviation FROM parc WHERE `nom`="'.$infoParc['parc'].'"');
    Database::disconnect();
    $infoAbrev = $resultat -> fetch(PDO::FETCH_ASSOC);

if (verif($_POST['runO_N']) == "oui") {
  $state = "RUN";
  $dateRun = date_format(new DateTime(verif($_POST['startDate'])), 'd/m/Y');
}else{
  $state = "STOP";
  $dateRun = "";
}
if ($infoLigne['pauseO_N'] == "non"){
  $state = "RUN";
  $dateRun = "";
}

$dest = "math.perlier@gmail.com";
$header = "From:"."mapir@vestas.com"."\r\n"."CC:"."mapir@vestas.com";

$objet = "";
$objet .= "OUT_TURBINE_".$infoLigne['serial']."_".$infoAbrev['abreviation']."_".$infoParc['pad'].""; 

$message = "";
$message .= "TURBINE ID: ".$infoLigne['serial']."\n";
$message .= "WINDFARM: ".$infoAbrev['abreviation']."_".$infoParc['pad']."\n";
$message .= "STIE_WTG_OUT \n";
$message .= "COMPANY: ".$infoLigne['company']."\n";
$message .= "TECH1: ".$infoLigne['initial1']."\n";
$message .= "TECH2: ".$infoLigne['initial2']."\n";
$message .= "TECH3: ".$infoLigne['initial3']."\n";
$message .= "OPERATION: ".verif($_POST['cr'])."\n";
$message .= "WTG STATE (RUN/STOP/LIMITED): ".$state."\n";
$message .= "WTG RUN DATE (dd/mm/yyyy): ".$dateRun."\n";
$message .= "WTG RUN TIME (hh:mm): ".verif($_POST['startHour'])."\n";
$message .= "SERVICE ORDER (OPTIONAL): ".$infoLigne['SO']."\n";

// print_r($message);
mail($dest, $objet, $message, $header);

?>