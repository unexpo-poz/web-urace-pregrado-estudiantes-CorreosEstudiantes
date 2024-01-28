<?php
 //-------------------------------------------------------------- 
 // Clase cliente para Conexion ODBC local This is the ODBC Socket Server class PHP client class
 // (c) 2005 Luis Tarazona - UNEXPO 
 $ODBCC_conBitacora = true;
 $ODBCC_sinBitacora = false;

 class ODBC_Conn {
	var $result = array(); // Resultado en una tabla
    var $result_h = array(); // Nombres de los campos en la tabla result  
	var $status =""; // Estado: 'OK', 'Tipo_de_Error'
    var $filas = 0; // Total de registros obtenidos
    var $fmodif= 0; // Total de registros modificados  
	var $usuario = "";
	var $clave = "";
	var $DSN = "";
	var $noSELECT = false; //Indica si es una consulta (SELECT) o no
	var $aBitacora = "";
	var $habBitacora = false;
	var $registroB = "";
	// Constructor	 
    function ODBC_Conn($SDSN, $Susuario, $Sclave, $habBitacora = false, $aBitacora="errores.log") {
        $this->DSN = $SDSN;
		$this->usuario = $Susuario;
		$this->clave = $Sclave;
		$this->habBitacora = $habBitacora;
		$this->aBitacora = $aBitacora;
		$this->registroB = date('h:i:s A [d/m/Y]')."\n";
       // $this->sHostName = $servidor;
    }
	// Convierte el resultado de la consulta a una tabla
    function result2array($respuesta) {
        unset($this->result);
        $this->result=array();
        unset($this->result_h);
        $this->result_h=array();
		if ($this->noSELECT) { // No es un select
			$this->fmodif = odbc_num_rows($respuesta);
			$this->filas = 0;
		}
		else { 
			$cols = odbc_num_fields($respuesta);
			for ($i=0; $i < $cols; $i++){
				$this->result_h[$i] = odbc_field_name($respuesta,$i+1);
			}
		$i = 0;
		while (0 <($cols = odbc_fetch_into($respuesta,$this->result[$i]))){
			$i++;
		}
		array_pop($this->result); // remueve registro vacio generado al fallar odbc_feth_into
			$this->filas = $i;
			$this->fmodif = 0;	
		}
		odbc_free_result($respuesta);
	}
	
	
	function escribirBitacora() {
			file_put_contents($this->aBitacora, $this->registroB, FILE_APPEND);
			$this->registroB = date('h:i:s A [d/m/Y]')."\n";
	}
	
	function ExecSQL($sSQL, $linea = "No_especificada", $actBitacora = false) {

		//print '<hd><br><pre>'. $sSQL . '</pre><br>'; 
		$todoOK = true;
		$this->noSELECT = (strpos(strtoupper($sSQL), 'SELECT') === false);
		$conex = odbc_connect($this->DSN, $this->usuario, $this->clave);
		$this->registroB .= $linea. ": " .$sSQL."\n";

		if(!$conex){
			$this->registroB = $this->registroB . odbc_errormsg()."\n";
			$this->escribirBitacora();
			//die ($this->registroB);
			return true;
		}
		$respuesta = odbc_do($conex, $sSQL);		
		if (!$respuesta) {
			$this->registroB = $this->registroB . odbc_errormsg()."\n";
			$this->escribirBitacora();
			//die ($this->registroB);
			return true;
		}
		$this->status = odbc_errormsg();
		if ($this->status == '') {
			$this->status = 'OK';
		}
		$this->result2array($respuesta);
		$this->registroB .= "[".$this->filas ."][".$this->fmodif."]";
		$this->registroB .= $this->status."\n";
		if ($actBitacora){
			$this->escribirBitacora();
		}
		return true;
	}
 }//class
// El servidor ODBCSS a usar:
?>
