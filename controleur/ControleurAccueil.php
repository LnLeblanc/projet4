<?php

require_once('modele/BilletManager.php');
require_once('modele/CommentaireManager.php');
require_once('vue/Vue.php');

class ControleurAccueil
{
    private $billet;
    private $commentaire;
    private $countBillet;
    private $countComm;
    
    public function __construct()
    {
        $this->billet = new BilletManager;
        $this->commentaire = new CommentaireManager;
    }

    // paramètres d'affichage des billets et des commentaires sur la page d'accueil et sécurisation de l'affichage
    public function accueil()
    {  
        // paramètres d'affichage des billets et des commentaires sur la page d'accueil
        $allBillets = $this->billet->getBilletsPublics(0, $this->billet->countBillets());
        $this->countBillet = $this->billet->countBillets() - 3;
        $derniersBillets = $this->billet->getBilletsPublics($this->countBillet, 3);
        $this->countComm = $this->commentaire->countCommentairesValide() - 3;
        $derniersCommentaires = $this->commentaire->getCommentairesValide($this->countComm, 3);

        // gestion du lien de connexion
        if (isset($_SESSION['identifiant']))
        {
            $connexion = 'index.php?action=admin';
        }
        else 
        {
            $connexion = '#connexion';
        }
        
        // on génère la vue
        $vue = new Vue('accueil');
        $vue->generer(array('allBillets' => $allBillets,
                            'derniersBillets' => $derniersBillets,
                            'derniersCommentaires' => $derniersCommentaires, 
                            'connexion' => $connexion));
    }
}