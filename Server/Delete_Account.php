<?php

require_once '../Class/Gestion_Class.php';
require_once '../Class/JWT.php';

$Jeton = $_POST['Jeton'];

$Decodage_Token = new GENERATION_TOKEN();
$Token = $Decodage_Token->Verifi_Jeton($Jeton);

if ($Token !== null && property_exists($Token, 'Id_Contrat')) {
    if ($Token->Id_Contrat == ROLE::Admin) {
        $Id = $_POST['idPersonne'];

        if ($Id != null) {
            $Gestion = new Gestion_Class();
            $Results = $Gestion->Delete_Accounts($Id);
            if ($Results[0] == RESULTAT::Ok) {
                $reponse['Code'] = $Results[0];
                $reponse['Message'] = $Results[1];
            } else {
                $reponse['Code'] = $Results[0];
                $reponse['Message'] = $Results[1];
            }
        } else {
            $reponse['Code'] = RESULTAT::Bad_Request;
            $reponse['Message'] = "Vous devez entrer toutes les informations";
        }
    } else {
        $reponse['Code'] = RESULTAT::Unauthorized;
        $reponse['Message'] = "Vous n'avez pas les droits pour effectuer cette action";
    }
} else {
    $reponse['Code'] = RESULTAT::Unauthorized;
    $reponse['Message'] = "Jeton invalide ou expiré";
}

header('Content-type: application/json');
echo (json_encode($reponse, JSON_UNESCAPED_UNICODE));
