<?php

    class Viaje {

        private $codigo;
        private $destino;
        private $maxpasajeros;
        private $pasajeros = [];

        public function __construct($code,$dest,$maxPa,$pa)   {

            $this->codigo = $code;
            $this->destino = $dest;
            $this->maxpasajeros = $maxPa;
            $this->pasajeros = $pa;

        }

        public function getCodigo() {
            return $this->codigo;
        }

        public function getDestino() {
            return $this->destino;
        }

        public function getMaxpasajeros() {
            return $this->maxpasajeros;
        }

        public function getPasajeros() {
            return $this->pasajeros;
        }

        public function setCodigo($codeN) {
            $this->codigo = $codeN;
        }

        public function setDestino($destinoN) {
            $this->destino = $destinoN;
        }

        public function setMaxpasajeros($maxpasajerosN) {
            $this->maxpasajeros = $maxpasajerosN;
        }

        public function setPasajeros($pasajerosN) {
            $this->pasajeros = $pasajerosN;
        }

        public function setNombrePasajero($nuevoNombre, $numPasajero) {
            $this->pasajeros[$numPasajero]['nombre'] = $nuevoNombre;
        }

        public function setApellidoPasajero($nuevoApellido, $numPasajero) {
            $this->pasajeros[$numPasajero]['apellido'] = $nuevoApellido;
        }

        public function setDocumentoPasajero($nuevoDocumento, $numPasajero) {
            $this->pasajeros[$numPasajero]['documento'] = $nuevoDocumento;
        }

        public function __toString() {
            return "Código de viaje: ". $this->codigo. "\nDestino del viaje: ". $this->destino. "\nCantidad máxima de pasajeros: ". $this->maxpasajeros. "\nCantidad de pasajeros: ". count($this->pasajeros);
        }
        
        public function listaDePasajeros() {
            //print_r($this->pasajeros);

            for ($i = 0; $i < count($this->pasajeros); $i++) {
                echo $i + 1 . ". ". $this->pasajeros[$i]['nombre']. " ". $this->pasajeros[$i]['apellido']. " - DNI: ". $this->pasajeros[$i]['documento']. "\n";
            }

        }

    /*La empresa de Transporte de Pasajeros “Viaje Feliz” quiere registrar la información referente a sus viajes. 
    De cada viaje se precisa almacenar el código del mismo, destino, cantidad máxima de pasajeros y los pasajeros del viaje.
    Realice la implementación de la clase Viaje e implemente los métodos necesarios para modificar los atributos de dicha clase 
    (incluso los datos de los pasajeros). Utilice un array que almacene la información correspondiente a los pasajeros. 
    Cada pasajero es un array asociativo con las claves “nombre”, “apellido” y “numero de documento”.*/

    }