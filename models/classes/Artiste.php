<?php
class Artiste {
    public $id;
    public $nom;
    public $prenom;
    public $genre;
    public $pays;
    public $biographie;

    public function __construct($id, $nom, $prenom, $genre, $pays, $biographie) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->genre = $genre;
        $this->pays = $pays;
        $this->biographie = $biographie;
    }
}
