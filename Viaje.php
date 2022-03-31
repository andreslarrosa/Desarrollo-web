<?php

    // Creamos la clase Viaje
    class Viaje {

        // Atributos privados de cada objeto
        private $codigo;
        private $destino;
        private $maxpasajeros;
        private $pasajeros = [];

        public function __construct($code,$dest,$maxPa,$pa)   {

            // Construimos un objeto y le asignamos dichos atributos
            $this->codigo = $code;
            $this->destino = $dest;
            $this->maxpasajeros = $maxPa;
            $this->pasajeros = $pa;

        }

        // Funciones Get para recibir información del objeto
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

        // Funciones Set para modificar los atributos de dicho objeto
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

        // Función to string para mostrar información del viaje
        // El cual no utilizo porque me pareció mejor mostrarlo de maneras distintas durante la ejecución del programa
        public function __toString() {
            return "Código de viaje: ". $this->codigo. "\nDestino del viaje: ". $this->destino. "\nCantidad máxima de pasajeros: ". $this->maxpasajeros. "\nCantidad de pasajeros: ". count($this->pasajeros);
        }
        
        // Función que muestra la lista de pasajeros con sus datos
        public function listaDePasajeros() {

            // En un principio usaba print_r, pero como no me gustaba como lo muestra decidí hacerlo manualmente
            // print_r($this->pasajeros);

            for ($i = 0; $i < count($this->pasajeros); $i++) {
                echo $i + 1 . ". ". $this->pasajeros[$i]['nombre']. " ". $this->pasajeros[$i]['apellido']. " - DNI: ". $this->pasajeros[$i]['documento']. "\n";
            }

        }

    }