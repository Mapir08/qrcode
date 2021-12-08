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

if ($runO_N == "oui") {
  $state = "RUN";
}else{
  $state = "STOP";
}

$date = date_format(new DateTime($date), 'd/m/Y');

if ($infoLigne['pauseO_N'] == "non"){
  $state = "RUN";
}

$to="math.perlier@gmail.com";
$subject = "OUT_TURBINE_".$infoLigne['serial']."_".$infoAbrev['abreviation']."_".$infoParc['pad'].""; 

$message = "";
$message .= "TURBINE ID: ".$infoLigne['serial']."\n";
$message .= "WINDFARM: ".$infoAbrev['abreviation']."_".$infoParc['pad']."\n";
$message .= "STIE_WTG_OUT \n";
$message .= "COMPANY: ".$infoLigne['company']."\n";
$message .= "TECH1: ".$infoLigne['initial1']."\n";
$message .= "TECH2: ".$infoLigne['initial2']."\n";
$message .= "TECH3: ".$infoLigne['initial3']."\n";
$message .= "OPERATION: ".$cr."\n";
$message .= "WTG STATE (RUN/STOP/LIMITED): ".$state."\n";
$message .= "WTG RUN DATE (dd/mm/yyyy): ".$date."\n";
$message .= "WTG RUN TIME (hh:mm): ".$hour."\n";
$message .= "SERVICE ORDER (OPTIONAL): ".$infoLigne['SO']."\n";

mail($to, $subject, $message);

?>