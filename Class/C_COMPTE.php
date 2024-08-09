<?php

class C_COMPTE {
    
    protected int $Id;
    protected string $Nom;
    protected string $Prenom;
    protected string $Login;
    protected string $Password;
    protected int $Role;

    public function __construct($Id, $Nom, $Prenom, $Login, $Password, $Role) {
        $this->Id = $Id;
        $this->Nom = $Nom;
        $this->Prenom = $Prenom;
        $this->Login = $Login;
        $this->Password = $Password;
        $this->Role = $Role;
    }


    public function getId(){
        return $this->Id;
    }

    public function getNom(){
        return $this->Nom;
    }

    public function getPrenom(){
        return $this->Prenom;
    }

    public function getLogin(){
        return $this->Login;
    }

    public function getPassword(){
        return $this->Password;
    }

    public function getRole(){
        return $this->Role;
    }

    
    public function setId($Id){
        $this->Id = $Id;
    }

    public function setNom($Nom){
        $this->Nom = $Nom;
    }

    public function setPrenom($Prenom){
        $this->Prenom = $Prenom;
    }

    public function setLogin($Login){
        $this->Login = $Login;
    }

    public function setPassword($Password){
        $this->Password = $Password;
    }

    public function setRole($Role){
        $this->Role = $Role;
    }
}


