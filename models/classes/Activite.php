<?php
class Activite {
    public $id;
    public $titre;
    public $type;
    public $date;
    public $lieu;
    public $photo;

    public function __construct($id, $titre, $type, $date, $lieu, $photo = null) {
        $this->id = $id;
        $this->titre = $titre;
        $this->type = $type;
        $this->date = $date;
        $this->lieu = $lieu;
        $this->photo = $photo;
    }
}
