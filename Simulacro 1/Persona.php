<?php

class Persona {

    private $nombre;
    private $apellido;
    private $direccion;
    //private $dni;
    private $mail;
    private $telefono;
    private $neto;

    public function __construct($nom,$ape,$dire,/*dni,*/$mail,$tel,$neto) {

        $this->nombre = $nom;
        $this->apellido = $ape;
        $this->direccion = $dire;
        //$this->dni = $dni;
        $this->mail = $mail;
        $this->telefono = $tel;
        $this->neto = $neto;

    }

    // Metodos Get

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    /*public function getDni() {
        return $this->dni;
    }*/

    public function getMail() {
        return $this->mail;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getNeto() {
        return $this->neto;
    }

    // Metodos Set

    public function setNombre($nom) {
        $this->nombre = $nom;;
    }

    public function setApellido($ape) {
        $this->apellido = $ape;
    }

    public function setDireccion($dire) {
        $this->direccion = $dire;
    }

    /*public function setDni($dni) {
        $this->dni = $dni;
    }*/

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function setTelefono($tel) {
        $this->telefono = $tel;
    }

    public function setNeto($neto) {
        $this->neto = $neto;
    }

    public function __toString() {
        return $this->getNombre(). " ". $this->getApellido(). "\nDirección: ". $this->getDireccion()./*"\nDni: ". $this->dni.*/ "\nE-Mail: ". $this->getMail(). "\nTeléfono: ". $this->getTelefono(). "\nNeto: ". $this->getNeto();
    }



}