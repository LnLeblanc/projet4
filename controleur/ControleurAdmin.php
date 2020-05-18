<?php

require_once('modele/BilletManager.php');
require_once('modele/CommentaireManager.php');
require_once('vue/Vue.php');
require_once('modele/Billet.php');

class ControleurAdmin
{
        private $billet;
        private $commentaire;
        private $chapitre;
    
    public function __construct()
    {
        $this->billet = new BilletManager;
        $this->commentaire = new CommentaireManager;
    }
    
    // page d'accueil de l'adminitration
    public function admin()
    {
        $billetsPublics = $this->billet->getBilletsPublics(0, $this->billet->countBillets());
        $billetsPrives = $this->billet->getBilletsPrives(0, $this->billet->countBilletsPrives());
        $commentaires = $this->commentaire->getCommentairesAValider(0, $this->commentaire->countCommentairesAValider());

        // on génère la vue
        $vue = new Vue('admin');
        $vue->generer(array('billetsPublics' => $billetsPublics,
                            'billetsPrives' => $billetsPrives,
                            'commentaires' => $commentaires));
    }
    
    // page de création d'un nouveau chapitre
    public function nouveauBillet()
    {
        $nouvelId = ($this->billet->countBillets() + $this->billet->countBilletsPrives() + 1);
        
        $vue = new Vue('nouveauChapitre');
        $vue->generer(array('nouvelId' => $nouvelId));
    }
    
    // retour à l'acceuil si erreur de mot de passe ou d'identifiant
    public function errConnexion()
    {
        $_SESSION['info'] = 'Erreur identifiant ou mot de passe';
        header('Location: index.php?#connexion');
    }
    
    // affiche un chapitre en cours d'écriture pour avoir un apperçu
    public function apercu($id)
    {
        $billet = $this->billet->getBilletPriveById($id);
        
        $vue = new Vue('apercu');
        $vue->generer(array('billet' => $billet));
    }
    
    public function postBillet($titre, $extrait, $contenu, $id)
    {
        $donnees = array('titre' => $titre, 
                        'extrait' => $extrait,
                        'contenu' => $contenu, 
                        'id' => $id);
        
        $billet = new Billet($donnees);
        $billet->setId($id);
        $billet->setTitre($titre);
        $billet->setExtrait($extrait);
        $billet->setContenu($contenu);
        
        $this->billet->postBillet($billet);
        $_SESSION['info'] = 'Votre chapitre en cours d\'écriture est enregistré';
        header('Location: index.php?action=admin');
    }
    
    // pour afficher la page de mise à jour du billet sélectionné
    public function update($id)
    {
        $billet = $this->billet->getBilletById($id);
        
        $vue = new Vue('miseAJour');
        $vue->generer(array('billet' => $billet));
    }
    
    // pour mettre à jour un chapitre déjà posté dans la BDD
    public function updateBillet($titre, $extrait, $contenu, $id)
    {
        $this->billet->updateBillet($titre, $extrait, $contenu, $id);
        $_SESSION['info'] = 'Votre chapitre a bien été mis à jour!';
        header('Location: index.php?action=admin#chapitresEnLigne');
    }
    
    // publication d'un billet
    public function publier($id)
    {
        $this->billet->rendrePublic($id);
        $_SESSION['info'] = 'Le chapitre est publié et maintenant visible depuis l\'accueil';
        header('Location: index.php?action=admin');
    }
    
    // suppression d'un billet
    public function deleteBillet($id)
    {
        $this->billet->deleteBillet($id);
        $_SESSION['info'] = 'Le chapitre a été supprimé.';
        header('Location: index.php?action=admin');
    }
    
    // validation d'un commentaire signalé
    public function updateCom($id)
    {
        $this->commentaire->updateCommentaire('TRUE', $id);
        $_SESSION['info'] = 'Le commentaire est validé.';
        header('Location: index.php?action=admin#gestionComm');
    }
    
    // suppression d'un commentaire signalé
    public function deleteCom($id)
    {
        $this->commentaire->deleteCommentaire($id);
        $_SESSION['info'] = 'Le commentaire est supprimé.';
        header('Location: index.php?action=admin#gestionComm');
    }
    
    // déconnexion de l'espace admin
    public function deconnexion() 
    {
        session_destroy();
        header('Location: index.php');
    }
}