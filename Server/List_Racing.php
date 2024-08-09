<?php

require_once '../Class/Gestion_Class.php';

$reponse = array();

$Gestion = new Gestion_Class();
$List = $Gestion->Get_List_Racing();
if ($List[0] == RESULTAT::Ok) {
    $reponse['table'] = $List[1];
    $reponse['code'] = $List[0];
} else {
    $reponse['code'] = $List[0];
    $reponse['message'] = $List[1];
}

header('Content-type: application/json');
echo (json_encode($reponse,JSON_UNESCAPED_UNICODE));