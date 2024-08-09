<?php

require_once '../Class/Gestion_Class.php';

$reponse = array();

$P_Id_Categorie = $_POST['idContrat'];

if($P_Id_Categorie != null){
    $Gestion = new Gestion_Class();
    $List = $Gestion->Get_List_By_Id_Contrat($P_Id_Categorie);
    if($List[0] == RESULTAT::Ok){
        $reponse['table'] = $List[2];
        $reponse['code'] = $List[0];
        $reponse['message'] = $List[1];
    }else {
        $reponse['code'] = $List[0];
        $reponse['message'] = $List[1];
    }

}else {
    $reponse['code'] = RESULTAT::Bad_Request;
    $reponse['message'] = "Erreur de tansmission de données";
}

var_dump($reponse);

header('Content-type: application/json');
echo (json_encode($reponse, JSON_UNESCAPED_UNICODE));

?>