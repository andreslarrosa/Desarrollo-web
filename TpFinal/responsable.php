<?php

include_once "BaseDatos.php";

class responsable
{

    private $rnumeroempleado;
    private $rnumerolicencia;
    private $rnombre;
    private $rapellido;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->rnumeroempleado = 0;
        $this->rnumerolicencia = "";
        $this->rnombre = "";
        $this->rapellido = "";
    }

    public function cargar($rNumEmpN, $rNumLicN, $nomN, $apeN)
    {
        $this->setRNumeroEmpleado($rNumEmpN);
        $this->setRNumeroLicencia($rNumLicN);
        $this->setRNombre($nomN);
        $this->setRApellido($apeN);
    }

    public function getRNumeroEmpleado()
    {
        return $this->rnumeroempleado;
    }

    public function getRNumeroLicencia()
    {
        return $this->rnumerolicencia;
    }

    public function getRNombre()
    {
        return $this->rnombre;
    }

    public function getRApellido()
    {
        return $this->rapellido;
    }

    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
    }

    public function setRNumeroEmpleado($numEmpN)
    {
        $this->rnumeroempleado = $numEmpN;
    }

    public function setRNumeroLicencia($numLicN)
    {
        $this->rnumerolicencia = $numLicN;
    }

    public function setRNombre($nomN)
    {
        $this->rnombre = $nomN;
    }

    public function setRApellido($apeN)
    {
        $this->rapellido = $apeN;
    }

    public function setmensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    public function __toString()
    {
        return $this->getRNombre() . " " . $this->getRApellido() . "\nNúmero de empleado: " . $this->getRNumeroEmpleado() . "\nNúmero de licencia: " . $this->getRNumeroLicencia();
    }

    public function Buscar($rNumEmp)
    {
        $base = new BaseDatos();
        $consultaResponsable = "Select * from responsable where rnumeroempleado=" . $rNumEmp;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaResponsable)) {
                if ($row2 = $base->Registro()) {
                    $this->setRNumeroEmpleado($rNumEmp);
                    $this->setRNumeroLicencia($row2['rnumerolicencia']);
                    $this->setRNombre($row2['rnombre']);
                    $this->setRApellido($row2['rapellido']);
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
        $arregloResponsable = null;
        $base = new BaseDatos();
        $consultaResponsables = "Select * from responsable ";
        if ($condicion != "") {
            $consultaResponsables = $consultaResponsables . ' where ' . $condicion;
        }
        $consultaResponsables .= " order by rnumeroempleado ";
        //echo $consultaPersonas;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaResponsables)) {
                $arregloResponsable = array();
                while ($row2 = $base->Registro()) {

                    $NroEmp = $row2['rnumeroempleado'];
                    $NroLic = $row2['rnumerolicencia'];
                    $NomRes = $row2['rnombre'];
                    $ApeRes = $row2['rapellido'];

                    $resp = new responsable();
                    $resp->cargar($NroEmp, $NroLic, $NomRes, $ApeRes);
                    array_push($arregloResponsable, $resp);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $arregloResponsable;
    }

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO responsable(rnumerolicencia, rnombre, rapellido) 
				VALUES ('" . $this->getRNumeroLicencia() . "','" . $this->getRNombre() . "','" . $this->getRApellido() . "')";

        if ($base->Iniciar()) {

            if ($base->Ejecutar($consultaInsertar)) {
                $this->setRNumeroEmpleado($base->DevolverID());;
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
        $consultaModifica = "UPDATE responsable SET rnumerolicencia='" . $this->getRNumeroLicencia() . "',rnombre='" . $this->getRNombre() . "'
                           ,rapellido='" . $this->getRApellido() . "' WHERE rnumeroempleado=" . $this->getRNumeroEmpleado();
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
            $consultaBorra = "DELETE FROM responsable WHERE rnumeroempleado=" . $this->getRNumeroEmpleado();
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
