<?php

require_once '../Class/Gestion_Class.php';
require_once '../Class/JWT.php';

$reponse = array();

$Login = $_POST['Login'];
$Password = $_POST['Password'];

if($Login != "" && $Password !=""){
    $Gestion = new Gestion_Class();
    $Results = $Gestion->Login_Accounts($Login,$Password);

    if($Results[0] == RESULTAT::Ok){

        $Data = $Results[2];
        $Generation_Token = new GENERATION_TOKEN();
        $Token = $Generation_Token->Generation_Jeton($Data['Id'], $Data['Nom'], $Data['Id_Contrat']);
        $Data['Jeton']= $Token;

        $reponse['table'] = $Data;
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