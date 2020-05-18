<?php
    // Création de la classe Modele pour générer la connexion à la BDD utilisée ensuite pour les requêtes
    abstract class Modele 
    {
        // attribut : objet PDO d'accès à la BDD
        private $bdd;
        
        // Pour éxecuter des requêtes éventuellement préparées
        protected function executerRequete($sql, $params = NULL) 
        {
            if ($params == NULL) 
            {
                $resultat = $this->getBdd()->query($sql);
            }
            else
            {
                $resultat = $this->getBdd()->prepare($sql);
                $resultat->execute($params);
            }
            return $resultat;
        }
        
        // Méthode qui renvoie l'objet de connexion à la BDD
        private function getBdd()
        {
            if ($this->bdd == null)
            {
                $this->bdd = new PDO('mysql:host=db676455993.db.1and1.com;dbname=db676455993;charset=utf8', 'dbo676455993', 'Olicien0605(L)', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => FALSE));
                // pour la connexion en local
                //$this->bdd = new PDO('mysql:host=localhost;dbname=projet4;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => FALSE));
            }
            return $this->bdd;
        }
    }