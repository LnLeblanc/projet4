<?php

// On appelle la classe qui fait la connexion à la BDD et les classes Billet et Commentaire pour récupérer les informations
require_once('modele/Modele.php');
require_once('modele/Billet.php');
//require_once('modele/Commentaire.php');

// Création de la classe BilletManager qui effectuera les requêtes en lien avec les billets
class BilletManager extends Modele
{
    // méthode pour récupérer tous les billets publiés
    public function getBilletsPublics($offset, $limit)
    {   
        $offset = (int)$offset;
        $limit = (int)$limit;
        $sql = 'SELECT id, titre, extrait, contenu, DATE_FORMAT(dateCrea, \'%d/%m/%Y\') AS dateCrea, public FROM billets WHERE public=\'TRUE\' ORDER BY id LIMIT ?, ?';
        
        $req = $this->executerRequete($sql, array($offset, $limit));
        $reponse = $req->fetchAll();
        $billets = array();
        foreach ($reponse as $billet) 
        {
            $billet = new Billet($billet);
            array_push($billets, $billet);
        }
        return $billets;
    }
    
    // méthode pour récupérer tous les billets pré-enregistrés
    public function getBilletsPrives($offset, $limit)
    {
        $offset = (int)$offset;
        $limit = (int)$limit;
        $sql = 'SELECT id, titre, extrait, contenu, DATE_FORMAT(dateCrea, \'%d/%m/%Y\') AS dateCrea, public FROM billets WHERE public=\'FALSE\' ORDER BY id LIMIT ?, ?';
        
        $req = $this->executerRequete($sql, array($offset, $limit));
        $reponse = $req->fetchAll();
        $billets = array();
        foreach ($reponse as $billet)
        {
            $billet = new Billet($billet);
            array_push($billets, $billet);
        }
        return $billets;
    }
    
    // méthode pour récupérer un billet en fonction de son id, qu'il soit public ou privé
    public function getBilletById($idBillet)
    {
        $idBillet = (int)$idBillet;
        $sql = 'SELECT id, titre, extrait, contenu, DATE_FORMAT(dateCrea, \'%d/%m/%Y\') AS dateCrea FROM billets WHERE id=:id_billet';
        
        $req = $this->executerRequete($sql, array($idBillet));
        $billet = $req->fetch();
        return $billet;
    }
    
    // méthode pour récupérer un seul billet en fonction de son id si il est pré enregistré et pas encore publié
    public function getBilletPriveById($idBillet)
    {
        $idBillet = (int)$idBillet;
        $sql = 'SELECT id, titre, extrait, contenu, DATE_FORMAT(dateCrea, \'%d/%m/%Y\') AS dateCrea, public FROM billets WHERE public=\'FALSE\' AND id=:id_billet';
        
        $req = $this->executerRequete($sql, array($idBillet));
        $billet = $req->fetch();
        return $billet;
    }
    
    // méthode pour récupérer un seul billet en fonction de son id si il est publié
    public function getBilletPublicById($idBillet)
    {
        $idBillet = (int)$idBillet;
        $sql = 'SELECT id, titre, extrait, contenu, DATE_FORMAT(dateCrea, \'%d/%m/%Y\') AS dateCrea FROM billets WHERE public=\'TRUE\' AND id=:id_billet';
        
        $req = $this->executerRequete($sql, array($idBillet));
        $billet = $req->fetch();
        return $billet;
    }
    
    // méthode pour poster un nouveau billet dans la BDD, privé par défaut
    public function postBillet(Billet $billet) 
    {
        if(isset($_POST['extrait']))
        {
            $sql = 'INSERT INTO billets (id, titre, extrait, contenu, dateCrea) VALUES(?, ?, ?, ?, NOW())';
            $array = array($billet->id(), $billet->titre(), $billet->extrait(), $billet->contenu());
            $this->executerRequete($sql, $array);
        }
    }
    
    // méthode pour supprimer un billet de la BDD, qu'il soit public ou privé
    public function deleteBillet($id)
    {
        $sql = 'DELETE FROM billets WHERE id = ?';
        $this->executerRequete($sql, array($id));
    }
    
    // méthode pour modifier un billet de la BDD, qu'il soit public ou privé
    public function updateBillet($titre, $extrait, $contenu, $id)
    {
        $sql = 'UPDATE billets SET titre = ?, extrait = ?, contenu = ? WHERE id = ?';
        $array = array($titre, $extrait, $contenu, $id);
        $nouveauBillet = $this->executerRequete($sql, $array);
        
        return $nouveauBillet;
    }
    
    // méthode pour rendre un billet privé public (accessible depuis l'accueil)
    public function rendrePublic($id)
    {
        $sql = 'UPDATE billets SET public = \'TRUE\' WHERE id = ?';
        $array = array($id);
        $billetPublic = $this->executerRequete($sql, $array);
        
        return $billetPublic;
    }
    
    // méthode pour renvoyer le nombre total de billets publiés
    public function countBillets()
    {
        $sql = 'SELECT COUNT(*) AS nbBillets FROM billets WHERE public=\'TRUE\'';
        $req = $this->executerRequete($sql);
        $resultat = $req->fetch();
        $nbBillets = (int)$resultat['nbBillets'];
        
        return $nbBillets;
    }
    
    // méthode pour renvoyer le nombre total de billets privés
    public function countBilletsPrives()
    {
        $sql = 'SELECT COUNT(*) AS nbBillets FROM billets WHERE public=\'FALSE\'';
        $req = $this->executerRequete($sql);
        $resultat = $req->fetch();
        $nbBillets = (int)$resultat['nbBillets'];
        
        return $nbBillets;
    }
}