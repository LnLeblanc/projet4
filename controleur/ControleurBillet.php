<?php

require_once('modele/BilletManager.php');
require_once('modele/CommentaireManager.php');
require_once('modele/Commentaire.php');
require_once('vue/Vue.php');

class ControleurBillet 
{
    private $billet;
    private $commentaire;
    
    public function __construct()
    {
        $this->billet = new BilletManager;
        $this->commentaire = new CommentaireManager;
    }
    
    public function billet($idBillet)
    {
        // s'il existe un billet correspondant à l'id passé par l'url on récupère uniquement le bon billet pour l'afficher avec les commentaires
        if (isset($_GET['id']))
        {
            $allBillets = $this->billet->getBilletsPublics(0, $this->billet->countBillets());
            $billet = $this->billet->getBilletPublicById($_GET['id']);
            // on demande les commentaires qui correspondent au bon billet
            $allCommentaires = $this->commentaire->getCommentairesByIdBillet(0, $this->commentaire->countCommentairesValide(), $_GET['id']);
            // on limite les commentaires à 5 par page pour la pagination
            $commentaires = $this->commentaire->getCommentairesByIdBillet(5 * ($_GET['page'] - 1), 5, $_GET['id']);
        }
        
        // pour la gestion des fonds d'écran
        $count = $this->billet->countBillets();
        $i=1;
        while($i<=$count)
        {
            if($_GET['id'] == $i)
            { 
                $section = 'com1';
            }
            elseif($_GET['id'] == $i+1)
            {
                $section = 'com2';
            }
            elseif($_GET['id'] == $i+2)
            {
                $section = 'com3';
            }
            elseif($_GET['id'] == $i+3)
            {
                $section = 'com4';
            }
            elseif($_GET['id'] == $i+4)
            {
                $section = 'com5';
            }
            $i= $i+5;
        }
        
        // gestion du lien de connexion
        $this->titre = $billet['titre']; 

        if (isset($_SESSION['identifiant']))
        {
            $connexion = '?action=admin';
        }
        else 
        {
            $connexion = '#connexion';
        }
        
        // pour la pagination des commentaires
        $nbPages = ceil(sizeof($allCommentaires) / 5);
        $nbBillets = $this->billet->countBillets();
        
        // on génère la vue
        $vue = new Vue('commentaire');
        $vue->generer(array('billet' => $billet, 
                            'commentaires' => $commentaires, 
                            'nbPages' => $nbPages, 
                            'nbBillets' => $nbBillets,
                            'allBillets' => $allBillets,
                            'section' => $section, 
                            'connexion' => $connexion
                           ));
        
    }
    
    // pour poster un nouveau commentaire
    public function commenter($auteur, $comm, $idBillet)
    {
        $donnees = array('auteur' => $auteur,
                         'commentaire' => $comm,
                         'idBillet' => $idBillet);
        $commentaire = new Commentaire($donnees);
        $commentaire->setAuteur($auteur);
        $commentaire->setCommentaire($comm);
        $commentaire->setId_billet($idBillet);
        
        $this->commentaire->postCommentaire($commentaire);
        $_SESSION['info'] = 'Votre commentaire a bien été publié ! ';
        header('Location: index.php?action=billet&id='.$idBillet.'&page=1#ajoutCom');
    }
    
    // pour signaler un commentaire 
    public function signalerCom($idCom, $idBillet)
    {
        $this->commentaire->updateCommentaire('FALSE', $idCom);
        $_SESSION['info'] = 'Le commentaire a été signalé à l\'auteur, merci. ';
        header('Location: index.php?action=billet&id='.$idBillet.'&page=1#postCom');
    }
}   