<?php

// Création de la classe Vue qui génère la vue du bon fichier quand il est appelé dans le controleur
class Vue
{
    private $fichier;
    private $titre;
    
    public function __construct($action)
    {
        $this->fichier = 'vue/' . $action . '.php';
    }
    
    // 
    public function generer($donnees)
    {
        $contenu = $this->genererFichier($this->fichier, $donnees);
        $vue = $this->genererFichier('vue/gabarit.php', array('titre' => $this->titre, 'contenu' => $contenu));
        
        echo $vue;
    }
    
    // méthode pour générer le bon fichier dans le gabarit
    private function genererFichier($fichier, $donnees)
    {
        if (file_exists($fichier))
        {
            extract($donnees);
            ob_start();
            require $fichier;
            
            return ob_get_clean();
        }
        else
        {
            throw new Exception("Fichier '$fichier' introuvable");
        }
    }
}