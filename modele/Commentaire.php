<?php

// définition de la classe Commentaire pour générer des objets commentaire
class Commentaire
{
    protected $id,
              $id_billet,
              $auteur,
              $commentaire,
              $date_commentaire,
              $valide;
    
    public function hydrate(array $donnees)
    {
        foreach($donnees as $key => $value)
        {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }
    
    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    // getters
    
    public function id()
    {
        return $this->id;
    }
    
    public function id_billet()
    {
        return $this->id_billet;
    }
    
    public function auteur()
    {
        return $this->auteur;
    }
    
    public function commentaire()
    {
        return $this->commentaire;
    }
    
    public function date_commentaire()
    {
        return $this->date_commentaire;
    }
    
    public function valide()
    {
        return $this->valide;
    }
    
    //setters
    
    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0)
        {
            $this->id = $id;
        }
    }
    
    public function setId_billet($id_billet)
    {
        $id_billet = (int) $id_billet;
        if ($id_billet > 0)
        {
            $this->id_billet = $id_billet;
        }
    }
    
    public function setAuteur($auteur)
    {
        if (is_string($auteur))
        {
            $this->auteur = $auteur;
        }
    }
    
    public function setCommentaire($commentaire)
    {
        if (is_string($commentaire))
        {
            $this->commentaire = $commentaire;
        }
    }
    
    public function setDate_commentaire($date_commentaire)
    {
        $this->date_commentaire = $date_commentaire;
    }
    
    public function setValide($valide)
    {
        if ($valide == 'TRUE' || $valide == 'FALSE')
        {
            $this->valide = $valide;
        }
    }
}