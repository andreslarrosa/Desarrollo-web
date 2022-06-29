<?php

include_once "BaseDatos.php";

class pasajero
{

	private $rdocumento;
	private $pnombre;
	private $papellido;
	private $ptelefono;
	private $idviaje;
	private $mensajeoperacion;

	public function __construct()
	{
		$this->rdocumento = "";
		$this->pnombre = "";
		$this->papellido = "";
		$this->ptelefono = "";
		$this->idviaje = "";
	}

	public function cargar($rDocN, $pNomN, $pApeN, $pTelN, $idViaN)
	{
		$this->setRDocumento($rDocN);
		$this->setPNombre($pNomN);
		$this->setPApellido($pApeN);
		$this->setPTelefono($pTelN);
		$this->setIDViaje($idViaN);
	}

	public function getRDocumento()
	{
		return $this->rdocumento;
	}

	public function getPNombre()
	{
		return $this->pnombre;
	}

	public function getPApellido()
	{
		return $this->papellido;
	}

	public function getPTelefono()
	{
		return $this->ptelefono;
	}

	public function getIDViaje()
	{
		return $this->idviaje;
	}

	public function getmensajeoperacion()
	{
		return $this->mensajeoperacion;
	}

	public function setRDocumento($rDocN)
	{
		$this->rdocumento = $rDocN;
	}

	public function setPNombre($pNomN)
	{
		$this->pnombre = $pNomN;
	}

	public function setPApellido($pApeN)
	{
		$this->papellido = $pApeN;
	}

	public function setPTelefono($pTelN)
	{
		$this->ptelefono = $pTelN;
	}

	public function setIDViaje($idViaN)
	{
		$this->idviaje = $idViaN;
	}

	public function setmensajeoperacion($mensajeoperacion)
	{
		$this->mensajeoperacion = $mensajeoperacion;
	}

	public function __toString()
	{
		return $this->getPNombre() . " " . $this->getPApellido() . "\nDocumento: " . $this->getRDocumento() . "\nTeléfono: " . $this->getPTelefono() . "\nViaje: " . $this->getIDViaje();
	}

	public function Buscar($dni)
	{
		$base = new BaseDatos();
		$consultaPasajero = "Select * from pasajero where rdocumento=" . $dni;
		$resp = false;
		if ($base->Iniciar()) {
			if ($base->Ejecutar($consultaPasajero)) {
				if ($row2 = $base->Registro()) {
					$this->setRDocumento($dni);
					$this->setPNombre($row2['pnombre']);
					$this->setPApellido($row2['papellido']);
					$this->setPTelefono($row2['ptelefono']);
					$this->setIDViaje($row2['idviaje']);
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
		$arregloPasajero = null;
		$base = new BaseDatos();
		$consultaPasajeros = "Select * from pasajero ";
		if ($condicion != "") {
			$consultaPasajeros = $consultaPasajeros . ' where ' . $condicion;
		}
		$consultaPasajeros .= " order by papellido ";
		//echo $consultaPersonas;
		if ($base->Iniciar()) {
			if ($base->Ejecutar($consultaPasajeros)) {
				$arregloPasajero = array();
				while ($row2 = $base->Registro()) {

					$NroDoc = $row2['rdocumento'];
					$Nombre = $row2['pnombre'];
					$Apellido = $row2['papellido'];
					$Telefono = $row2['ptelefono'];
					$IdViaje = $row2['idviaje'];

					$pasaj = new pasajero();
					$pasaj->cargar($NroDoc, $Nombre, $Apellido, $Telefono, $IdViaje);
					array_push($arregloPasajero, $pasaj);
				}
			} else {
				$this->setmensajeoperacion($base->getError());
			}
		} else {
			$this->setmensajeoperacion($base->getError());
		}
		return $arregloPasajero;
	}

	public function insertar()
	{
		$base = new BaseDatos();
		$resp = false;
		$consultaInsertar = "INSERT INTO pasajero(rdocumento, pnombre, papellido, ptelefono, idviaje) 
				VALUES (" . $this->getRDocumento() . ",'" . $this->getPNombre() . "','" . $this->getPApellido() . "','" . $this->getPtelefono() . "','" . $this->getIDViaje() . "')";

		if ($base->Iniciar()) {

			if ($base->Ejecutar($consultaInsertar)) {

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
		$consultaModifica = "UPDATE pasajero SET papellido='" . $this->getPApellido() . "',pnombre='" . $this->getPNombre() . "'
                           ,ptelefono='" . $this->getPTelefono() . "',idviaje='" . $this->getIDViaje() . "' WHERE rdocumento=" . $this->getRDocumento();
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
			$consultaBorra = "DELETE FROM pasajero WHERE rdocumento=" . $this->getRDocumento();
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
