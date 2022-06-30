<?php

include_once "BaseDatos.php";

class viaje
{

    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $objempresa;
    private $objempleado;
    private $vimporte;
    private $tipoAsiento;
    private $idayvuelta;
    private $mensajeoperacion;

    public function __construct()
    {

        $this->idviaje = 0;
        $this->vdestino = "";
        $this->vcantmaxpasajeros = "";
        $this->vimporte = "";
        $this->tipoAsiento = "";
        $this->idayvuelta = "";
    }

    public function cargar($idViajeN,$vDestN, $vCantMaxPsjN, $idEmpN, $rNumEmpN, $vImpN, $tipoAsiN, $idaYVN)
    {
        $this->setIdViaje($idViajeN);
        $this->setVDestino($vDestN);
        $this->setVCantMaxPasajeros($vCantMaxPsjN);
        $this->setObjEmpresa($idEmpN);
        $this->setObjEmpleado($rNumEmpN);
        $this->setVImporte($vImpN);
        $this->setTipoAsiento($tipoAsiN);
        $this->setIdaYVuelta($idaYVN);
    }

    public function getIdViaje()
    {
        return $this->idviaje;
    }

    public function getVDestino()
    {
        return $this->vdestino;
    }

    public function getVCantMaxPasajeros()
    {
        return $this->vcantmaxpasajeros;
    }

    public function getObjEmpresa()
    {
        return $this->objempresa;
    }

    public function getObjEmpleado()
    {
        return $this->objempleado;
    }

    public function getVImporte()
    {
        return $this->vimporte;
    }

    public function getTipoAsiento()
    {
        return $this->tipoAsiento;
    }

    public function getIdaYVuelta()
    {
        return $this->idayvuelta;
    }

    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
    }

    public function setIdViaje($idViaN)
    {
        $this->idviaje = $idViaN;
    }

    public function setVDestino($vDestN)
    {
        $this->vdestino = $vDestN;
    }

    public function setVCantMaxPasajeros($vCantMaxPsjN)
    {
        $this->vcantmaxpasajeros = $vCantMaxPsjN;
    }

    public function setObjEmpresa($idEmpN)
    {
        $this->objempresa = $idEmpN;
    }

    public function setObjEmpleado($rNumEmpN)
    {
        $this->objempleado = $rNumEmpN;
    }

    public function setVImporte($vImpN)
    {
        $this->vimporte = $vImpN;
    }

    public function setTipoAsiento($tipoAsiN)
    {
        $this->tipoAsiento = $tipoAsiN;
    }

    public function setIdaYVuelta($idaYVN)
    {
        $this->idayvuelta = $idaYVN;
    }

    public function setmensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    public function __toString()
    {
        return "Id del viaje: " . $this->getIdViaje() . "\nDestino: " . $this->getVDestino() . "\nPasajeros máximos: " . $this->getVCantMaxPasajeros() . "\nId Empresa: ". $this->getObjEmpresa()->getIdEmpresa(). 
            "\nNúmero de empleado: " . $this->getObjEmpleado()->getRNumeroEmpleado() . "\nImporte: " . $this->getVImporte() . "\nAsientos: " . $this->getTipoAsiento() . "\nIda y Vuelta: " . $this->getIdaYVuelta();
    }

    public function Buscar($idViaje)
    {
        $base = new BaseDatos();
        $consultaViaje = "Select * from viaje where idviaje=" . $idViaje;
		$resp = false;
		if ($base->Iniciar()) {
			if ($base->Ejecutar($consultaViaje)) {
				if ($row2 = $base->Registro()) {
                    $this->setIdViaje($idViaje);
                    $this->setVDestino($row2['vdestino']);
                    $this->setVCantMaxPasajeros($row2['vcantmaxpasajeros']);
                    $objEmpTemp = new empresa();
                    $objEmpTemp->Buscar($row2['idempresa']);
                    $this->setObjEmpresa($objEmpTemp);
                    $objRespTemp = new responsable();
                    $objRespTemp->Buscar($row2['rnumeroempleado']);
                    $this->setObjEmpleado($objRespTemp);
                    $this->setVImporte($row2['vimporte']);
                    $this->setTipoAsiento($row2['tipoAsiento']);
                    $this->setIdaYVuelta($row2['idayvuelta']);
                    $resp = true;
                }
			} else {
				$this->setmensajeoperacion($base->getError());
			}
		} else {
			$this->setmensajeoperacion($base->getError());
		}
		return $resp;
	}

    public static function listar($condicion = "")
    {
        $arregloViaje = null;
        $base = new BaseDatos();
        $consultaViajes = "Select * from viaje ";
        if ($condicion != "") {
            $consultaViajes = $consultaViajes . ' where ' . $condicion;
        }
        $consultaViajes .= " order by idviaje ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaViajes)) {
                $arregloViaje = array();
                while($row2=$base->Registro()) {
                    $viaj = new viaje();
                    $viaj->Buscar($row2['idviaje']);
                    array_push($arregloViaje, $viaj);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $arregloViaje;
    }

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar="INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte, tipoAsiento,  idayvuelta) 
				VALUES ('".$this->getVDestino()."','".$this->getVCantMaxPasajeros()."','".$this->getObjEmpresa()->getIdEmpresa()."','".$this->getObjEmpleado()->getRNumeroEmpleado()."','".$this->getVImporte()."','".$this->getTipoAsiento()."','".$this->getIdaYVuelta()."')";

        if ($base->Iniciar()) {

            if ($base->Ejecutar($consultaInsertar)) {
                $this->setIdViaje($base->DevolverID());;
                $resp =  true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $consultaModifica = "UPDATE viaje SET vdestino='" . $this->getVDestino() . "',vcantmaxpasajeros='" . $this->getVCantMaxPasajeros() . "'
                           ,idempresa='" . $this->getObjEmpresa()->getIdEmpresa() . "',rnumeroempleado='" . $this->getObjEmpleado()->getRNumeroEmpleado() . "'
                           ,vimporte='" . $this->getVImporte() . "',tipoAsiento='" . $this->getTipoAsiento() . "',idayvuelta='" . $this->getIdaYVuelta() . "' WHERE idviaje=" . $this->getIdViaje();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaModifica)) {
                $resp =  true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consultaBorra = "DELETE FROM viaje WHERE idviaje=" . $this->getIdViaje();
            if ($base->Ejecutar($consultaBorra)) {
                $resp =  true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }
}
