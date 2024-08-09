<?php

require_once '../Class/Gestion_Class.php';

$reponse = array();

$P_Nom = $_POST['Nom'];
$P_Prenom = $_POST['Prenom'];
$P_Login = $_POST['Login'];
$P_Password = $_POST['Password'];

if($P_Nom !="" && $P_Prenom !="" && $P_Login != "" && $P_Password !=""){
    $Gestion = new Gestion_Class();
    $Results = $Gestion->Add_Accounts($P_Nom,$P_Prenom,$P_Login,$P_Password);
    if($Results[0] == RESULTAT::Ok){
        $reponse['Code'] = $Results[0];
        $reponse['Message'] = $Results[1];
    }else{
        $reponse['Code'] = $Results[0];
        $reponse['Message'] = $Results[1];
    }
}else{
    $reponse['Code'] = RESULTAT::Bad_Request;
    $reponse['Message'] = "Vous devais entrer toute les information";
}
header('Content-type: application/json');
echo (json_encode($reponse, JSON_UNESCAPED_UNICODE));

?>