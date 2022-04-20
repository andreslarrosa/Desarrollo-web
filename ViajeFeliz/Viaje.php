<?php

    // Creamos la clase Viaje
    class Viaje {

        // Atributos privados de cada objeto
        private $codigo;
        private $destino;
        private $maxPasajeros;
        private $pasajeros = [];
        private $responsable;

        public function __construct($code,$dest,$maxPa,$pa,$resp)   {

            // Construimos un objeto y le asignamos dichos atributos
            $this->codigo = $code;
            $this->destino = $dest;
            $this->maxPasajeros = $maxPa;
            $this->pasajeros = $pa;
            $this->responsable = $resp;

        }

        // Funciones Get para recibir información de los atributos del objeto
        public function getCodigo() {
            return $this->codigo;
        }

        public function getDestino() {
            return $this->destino;
        }

        public function getMaxPasajeros() {
            return $this->maxPasajeros;
        }

        public function getPasajeros() {
            return $this->pasajeros;
        }

        public function getResponsable() {
            return $this->responsable;
        }

        // Funciones Set para modificar los atributos de dicho objeto
        public function setCodigo($codeN) {
            $this->codigo = $codeN;
        }

        public function setDestino($destinoN) {
            $this->destino = $destinoN;
        }

        public function setMaxPasajeros($maxPasajerosN) {
            $this->maxPasajeros = $maxPasajerosN;
        }

        public function setPasajeros($pasajerosN) {
            $this->pasajeros = $pasajerosN;
        }

        public function setResponsable($responsableN) {
            $this->responsable = $responsableN;
        }

        // Función to string para mostrar información del viaje
        // El cual no utilizo porque me pareció mejor mostrarlo de maneras distintas durante la ejecución del programa
        public function __toString() {
            return "Código de viaje: ". $this->getCodigo(). "\nDestino del viaje: ". $this->getDestino(). "\nCantidad máxima de pasajeros: ". $this->getMaxPasajeros(). "\nCantidad de pasajeros: ". count($this->getPasajeros()). "\nResponsable: ". $this->getResponsable(). "\nPasajeros:\n". $this->listaDePasajeros();
        }

        // Función que muestra la lista de pasajeros
        public function listaDePasajeros() {

            $stringPasajeros = "";

            for ($i=0;$i<count($this->getPasajeros());$i++) {
                $stringPasajeros .= ($i+1). ". ". $this->getPasajeros()[$i]. "\n";
            }

            return $stringPasajeros;

        }
    }