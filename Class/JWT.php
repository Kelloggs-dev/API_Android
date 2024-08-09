<?php
require_once '../vendor/autoload.php'; 

use \Firebase\JWT\JWT; 
use \Firebase\JWT\Key;

class GENERATION_TOKEN{

    private $secret_key = "062140277d049d9767735b1864edd24493a7031b19b5f4a14e235977f505799631d7da6bdb7ad4ad046b0f23e7c35a5b5ee0e9f0b44870be41fb73aa920f763c";

    public function Generation_Jeton(int $Id,string $Nom,int $Id_Contrat){
        $playload = array(
            "Id_User" => $Id,
            "Nom" => $Nom,
            "Id_Contrat" => $Id_Contrat,
            'exp' => time() + 3600
        );
        return JWT::encode($playload,$this->secret_key, 'HS512');
    }

    public function Verifi_Jeton($token) {

        try {
            $decoded = jwt::decode($token, new key($this->secret_key,'HS512'));
            return $decoded; 
        } catch (Exception $e) {
            return $e; 
        }
    }


}



