<?php

// définition de la classe Billet pour générer des objets billet
class Billet 
{
    protected $id,
              $titre,
              $extrait,
              $contenu,
              $dateCrea;
    
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
    
    //getters
    
    public function id()
    {
        return $this->id;
    }
    
    public function titre()
    {
        return $this->titre;
    }
    
    public function extrait()
    {
        return $this->extrait;
    }
    public function contenu()
    {
        return $this->contenu;
    }
    public function dateCrea()
    {
        return $this->dateCrea;
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
    
    public function setTitre($titre)
    {
        if (is_string($titre))
        {
            $this->titre = $titre;   
        }
    }
    
    public function setExtrait($extrait)
    {
        if (is_string($extrait))
        {
            $this->extrait = $extrait;   
        }
    }
    
    public function setContenu($contenu)
    {
        if (is_string($contenu))
        {
            $this->contenu = $contenu;   
        }
    }
    public function setDateCrea($dateCrea)
    {
        $this->dateCrea = $dateCrea;
    }
}