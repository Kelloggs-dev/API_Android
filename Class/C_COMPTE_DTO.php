<?php

class C_COMPTE_DTO {

    protected int $Id;
    protected string $Nom;
    protected string $Prenom;
    protected int $Id_Contrat;
    protected $Jeton;

    // Constructeur
    public function __construct($Id, $Nom, $Prenom, $Id_Contrat) {
        $this->Id = $Id;
        $this->Nom = $Nom;
        $this->Prenom = $Prenom;
        $this->Id_Contrat = $Id_Contrat;
    }


    public function getId() {
        return $this->Id;
    }

    public function getNom() {
        return $this->Nom;
    }

    public function getPrenom() {
        return $this->Prenom;
    }

    public function getIdContrat() {
        return $this->Id_Contrat;
    }


    public function setId($Id) {
        $this->Id = $Id;
    }

    public function setNom($Nom) {
        $this->Nom = $Nom;
    }

    public function setPrenom($Prenom) {
        $this->Prenom = $Prenom;
    }

    public function setIdContrat($Id_Contrat) {
        $this->Id_Contrat = $Id_Contrat;
    }

    public function setJeton($Jeton) {
        $this->Jeton = $Jeton;
    }

    public function toArray() {
        return [
            'Id' => $this->Id,
            'Nom' => $this->Nom,
            'Prenom' => $this->Prenom,
            'Id_Contrat' => $this->Id_Contrat,
            'Jeton' => $this->Jeton

        ];
    }
}


