<?php 
require_once('modele/ConnexionManager.php');

class ControleurConnexion
{
    private $connexion;
    
    public function __construct()
    {
        $this->connexion = new ConnexionManager;
    }
    
    public function identifiant()
    {
        $connexionJean = $this->connexion->getConnexion();
        $identifiant = $connexionJean['identifiant'];
        
        return $identifiant;
    }
    
    public function motdepasse()
    {
        $connexionJean = $this->connexion->getConnexion();
        $motdepasse = $connexionJean['motdepasse'];
        
        return $motdepasse;
    }
}