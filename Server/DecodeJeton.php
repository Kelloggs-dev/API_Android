<?php

require_once '../Class/JWT.php';
require_once '../Class/Gestion_Class.php';

$Jeton = $_POST['Jeton'];

if($Jeton != ""){
    $Decodage_Token = new GENERATION_TOKEN();
    $Token = $Decodage_Token->Verifi_Jeton($Jeton);
    if($Token->Id_Contrat == ROLE::Admin){

        $reponse['Id_Contrat'] = $Token->Id_Contrat;
        $reponse['Code'] = RESULTAT::Ok;
        $New_Token = $Decodage_Token->Generation_Jeton($Token->Id_User,$Token->Nom,$Token->Id_Contrat);
        $reponse['Jeton'] = $New_Token;
    }else{
        $reponse['Id_Contrat'] = $Token->Id_Contrat;
        $reponse['Code'] = RESULTAT::Ok;
        $New_Token = $Decodage_Token->Generation_Jeton($Token->Id_User,$Token->Nom,$Token->Id_Contrat);
        $reponse['Jeton'] = $New_Token;
    }
}else{
    $reponse['Code'] = RESULTAT::Bad_Request;
    $reponse['Message'] = "Jeton non transmis";
}

header('Content-type: application/json');
echo (json_encode($reponse, JSON_UNESCAPED_UNICODE));

?>