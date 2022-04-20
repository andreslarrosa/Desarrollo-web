<?php

class Pasajero
{

    private $nombre;
    private $apellido;
    private $documento;
    private $telefono;

    public function __construct($nom, $ape, $doc, $tel)
    {

        $this->nombre = $nom;
        $this->apellido = $ape;
        $this->documento = $doc;
        $this->telefono = $tel;
    }

    // Métodos Get

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getDocumento()
    {
        return $this->documento;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }


    // Métodos Set

    public function setNombre($nombreN)
    {
        $this->nombre = $nombreN;
    }

    public function setApellido($apellidoN)
    {
        $this->apellido = $apellidoN;
    }

    public function setDocumento($documentoN)
    {
        $this->documento = $documentoN;
    }

    public function setTelefono($telefonoN)
    {
        $this->telefono = $telefonoN;
    }

    // Otros métodos

    public function __toString()
    {

        return $this->getNombre() . " " . $this->getApellido() . " - DNI: " . $this->getDocumento() . " - Teléfono: " . $this->getTelefono();
    }
}
