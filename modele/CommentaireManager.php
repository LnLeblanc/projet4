<?php

// On appelle la classe qui fait la connexion à la BDD et les classes Billet et Commentaire pour récupérer les informations
require_once('modele/Modele.php');
require_once('modele/Billet.php');
require_once('modele/Commentaire.php');

// Création de la classe CommentaireManager qui effectuera les requêtes en lien avec les commentaires
class CommentaireManager extends Modele
{
    // Récupération des commentaires signalés à valider
    public function getCommentairesAValider($offset, $limit)
    {
        $offset = (int)$offset;
        $limit = (int)$limit;
        $sql = 'SELECT id, id_billet, auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y\') AS dateCommentaire, valide FROM commentaires WHERE valide=\'FALSE\' ORDER BY date_commentaire LIMIT :offset, :limit';
        
        $req = $this->executerRequete($sql, array($offset, $limit));
        $reponse = $req->fetchAll();
        $commentaires = array();
        foreach ($reponse as $commentaire)
        {
            $commentaire = new Commentaire($commentaire);
            array_push($commentaires, $commentaire);
        }
        return $commentaires;
    }
    // Récupération des commentaires validés
    public function getCommentairesValide($offset, $limit)
    {
        $offset = (int)$offset;
        $limit = (int)$limit;
        $sql = 'SELECT id, id_billet, auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y\') AS date_commentaire, valide FROM commentaires WHERE valide=\'TRUE\' ORDER BY date_commentaire LIMIT :offset, :limit';
        
        $req = $this->executerRequete($sql, array($offset, $limit));
        $reponse = $req->fetchAll();
        $commentaires = array();
        foreach ($reponse as $commentaire)
        {
            $commentaire = new Commentaire($commentaire);
            array_push($commentaires, $commentaire);
        }
        return $commentaires;
    }
    
    // récupération des commentaires en fonction de l'id du billet correspondant
    public function getCommentairesByIdBillet($offset, $limit, $id)
    {
        $offset = (int)$offset;
        $limit = (int)$limit;
        $id = (int)$id;
        
        $sql = 'SELECT id, id_billet, auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y\') AS date_commentaire, valide FROM commentaires WHERE id_billet=:id ORDER BY date_commentaire LIMIT :offset, :limit';
        
        $req = $this->executerRequete($sql, array($id, $offset, $limit));
        $reponse = $req->fetchAll();
        $commentairesById = array();
        foreach($reponse as $commentaireById)
        {
            $commentaireById = new Commentaire($commentaireById);
            array_push($commentairesById, $commentaireById);
        }
        return $commentairesById;
    }
    
    // Ajout des nouveaux commentaires à la BDD, validés par défaut
    public function postCommentaire(Commentaire $commentaire)
    {
        if (isset($_POST['idBillet']))
        {
            $sql = 'INSERT INTO commentaires (id_billet, auteur, commentaire, date_commentaire) VALUES(?, ?, ?, NOW())';
            $array = array($commentaire->id_billet(), $commentaire->auteur(), $commentaire->commentaire());
            $donnees = $this->executerRequete($sql, $array);
            
            return $donnees;
        }
    }
    
    // Supprimer un commentaire de la BDD
    public function deleteCommentaire($id)
    {
        $sql = 'DELETE FROM commentaires WHERE id = ?';
        $this->executerRequete($sql, array($id));
    }
    
    // Mise à jour des commentaires pour les afficher après validation
    public function updateCommentaire($valide, $id)
    {
        $sql = 'UPDATE commentaires SET valide=? WHERE id = ?';
        $array = array($valide, $id);
        $nouveauCom = $this->executerRequete($sql, $array);
        
        return $nouveauCom;
    }
    
    // pour retourner le nombre total de commentaires signalés à valider
    public function countCommentairesAValider()
    {
        $sql = 'SELECT COUNT(*) AS nbCommentaires FROM commentaires WHERE valide = \'FALSE\'';
        $req = $this->executerRequete($sql);
        $resultat = $req->fetch();
        $nbCommentaires = (int)$resultat['nbCommentaires'];
        
        return $nbCommentaires;
    }
    
    // pour retourner le nombre total de commentaires validés et postés
    public function countCommentairesValide()
    {
        $sql = 'SELECT COUNT(*) AS nbCommentaires FROM commentaires WHERE valide = \'TRUE\'';
        $req = $this->executerRequete($sql);
        $resultat = $req->fetch();
        $nbCommentaires = (int)$resultat['nbCommentaires'];
        
        return $nbCommentaires;
    }
}