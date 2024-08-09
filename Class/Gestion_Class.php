<?php

require_once("Connexion_Class.php");

class RESULTAT
{
    const Ok = 200;
    const Not_Found = 404;
    const Bad_Request = 400;
    const Conflict = 409;
    const Unauthorized = 401;
}

class ROLE
{

    const Invite = 0;
    const Driver = 1;
    const Mecano = 2;
    const Visiteur = 3;
    const Admin = 500;
}

class Gestion_Class
{

    private $cnx;


    // Connexion a la base dans le constructeur

    public function __construct()
    {

        $this->cnx = connectSqlsrv();
    }



    public function Get_List_By_Id_Contrat($P_Id_Contrat)
    {
        $Requete = $this->cnx->prepare("SELECT idPersonne, Nom, Prenom, idContrat 
                                        FROM Personne 
                                        WHERE idContrat = :idContrat");

        $Requete->bindParam(":idContrat", $P_Id_Contrat);
        $Requete->execute();

        $Results = $Requete->fetchAll(PDO::FETCH_OBJ);

        $cnx = null;

        if ($Results) {
            require_once("C_COMPTE_DTO.php");

            $List_Compte = [];

            foreach ($Results as $Compte) {
                $Compte_DTO = new C_COMPTE_DTO(
                    $Compte->idPersonne,
                    $Compte->Nom,
                    $Compte->Prenom,
                    $Compte->idContrat
                );
                $List_Compte[] = $Compte_DTO->toArray();
                
            }

            return [RESULTAT::Ok,"Récupération de données OK", $List_Compte];
        } else return [RESULTAT::Not_Found,"Erreur"];
    }

    public function Get_List_Personne()
    {

        $Requete = $this->cnx->prepare("SELECT idPersonne, Nom, Prenom,idContrat
                                        FROM Personne");
        $Requete->execute();

        $Results = $Requete->fetchAll(PDO::FETCH_OBJ);

        $cnx = null;

        if ($Results) {

            require_once("C_COMPTE_DTO.php");

            $List_Compte = array();

            foreach ($Results as $Compte) {
                $Compte_DTO = new C_COMPTE_DTO(
                    $Compte->idPersonne,
                    $Compte->Nom,
                    $Compte->Prenom,
                    $Compte->idContrat
                );
                $List_Compte[] = $Compte_DTO->toArray();
            }
            return [RESULTAT::Ok,"Récupération de données OK", $List_Compte];
        } else return [RESULTAT::Not_Found,"Erreur"];
    }

    public function Get_List_Pilote(){
        
        $Requete = $this->cnx->prepare("EXEC list_Driver");
        $Requete->execute();
        $Results = $Requete->fetchAll(PDO::FETCH_ASSOC);

        if($Results){
            return [RESULTAT::Ok,$Results];
        }else return [RESULTAT::Not_Found,"Erreur"];
    }

    public function Get_List_Racing(){
        
        $Requete = $this->cnx->prepare("EXEC List_Racing");
        $Requete->execute();
        $Results = $Requete->fetchAll(PDO::FETCH_ASSOC);

        if($Results){
            return [RESULTAT::Ok,$Results];
        }else return [RESULTAT::Not_Found,"Erreur"];
    }

    public function Recherche_Si_Email_Exist(string $P_Email)
    {

        $sql = "select idPersonne,Nom,Prenom,Login,Password,idContrat 
                from Personne
                where Login = :Email";

        $stmt = $this->cnx->prepare($sql);
        $stmt->bindParam(':Email', $P_Email);
        $stmt->execute();
        $Results = $stmt->fetch(PDO::FETCH_OBJ);
        $cnx= null;
        if ($Results) { // Changement ici pour vérifier si $Results est différent de false
            require_once("C_COMPTE.php");
    
            $Compte_User = new C_COMPTE(
                $Results->idPersonne,
                $Results->Nom,
                $Results->Prenom,
                $Results->Login,
                $Results->Password,
                $Results->idContrat
            );
            return [RESULTAT::Ok, $Compte_User];
        } else return [RESULTAT::Not_Found];
    }

    public function Add_Accounts(string $P_Nom, string $P_Prenom, string $P_Login, string $P_Password)
    {

        $Results = $this->Recherche_Si_Email_Exist($P_Login);
        if ($Results[0] == RESULTAT::Not_Found) {

            $pwd = password_hash($P_Password, PASSWORD_DEFAULT);

            $Role = ROLE::Invite;

            $sql = "insert into Personne(Nom, Prenom, Login, Password, idContrat) values (:Nom, :Prenom, :Login, :Password, :idContrat)";

            $stmt = $this->cnx->prepare($sql);


            $stmt->bindParam(':Nom', $P_Nom);
            $stmt->bindParam(':Prenom', $P_Prenom);
            $stmt->bindParam(':Login', $P_Login);
            $stmt->bindParam(':Password', $pwd);
            $stmt->bindParam(':idContrat', $Role);

            $stmt->execute();
            $cnx = null;
            $stmt = null;
            return [RESULTAT::Ok, "Inscription reussi redirection en cours "];
        } else return [RESULTAT::Not_Found, "Votre adress mail existe dejaj"];
    }

    public function Login_Accounts(string $P_Email, string $P_Password)
    {

        $Results = $this->Recherche_Si_Email_Exist($P_Email);

        if ($Results[0] == RESULTAT::Ok) {

            $Data = $Results[1];

            $Pass = $Data->getPassword();

            if (password_verify($P_Password, $Pass)) {
                require_once("C_COMPTE_DTO.php");
                $Compte_DTO = new C_COMPTE_DTO(
                    $Data->getId(),
                    $Data->getNom(),
                    $Data->getPrenom(),
                    $Data->getRole()
                );

                return [RESULTAT::Ok, "Connexion reussi redirection en cours ", $Compte_DTO->toArray()];
            } else return [RESULTAT::Unauthorized, "Mot de passe incorrect"];
        } else return [RESULTAT::Not_Found, "Adresse mail incorrect ou n'existe pas"];
    }

    public function Delete_Accounts(int $P_Id)
    {

        $Requete = $this->cnx->prepare("SELECT idPersonne FROM Personne
                                        WHERE idPersonne = :Id");

        $Requete->bindParam(":Id", $P_Id);
        $Requete->execute();

        $Results = $Requete->fetch();

        $cnx = null;

        if ($Results) {
            $Requete = $this->cnx->prepare("DELETE FROM Personne WHERE idPersonne = :Id");
            $Requete->bindParam(":Id", $Results['idPersonne']);
            $Requete->execute();
            $cnx = null;
            return [RESULTAT::Ok, "La suppression a bien été effectuée"];
        } else {
            return [RESULTAT::Not_Found, "Erreur: la personne n'existe pas"];
        }
    }
}
