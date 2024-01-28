<?php
 session_start();
//------------------------------------------------------------------
// P10_CrearCSV.php
//------------------------------------------------------------------
// Proceso N°		:	1
// Objetivo			:	Descarga datos de la base de datos de correo
//						de estudiante que solicitaron reinicio de clave
//						de la tabla DACE002 de las BD DACE y CARORA en
//						archivo con formato CSV, según Sede y Lapso. Es
//						invocado por P1_GenCSVdesdeCent.php
//
// Creditos:	José Mujica
//------------------------------------------------------------------


$Sede	= $_POST["Sede"];
$Lapso	= $_POST['Lapso'];
$Esp	= '1';//$_POST['Esp'];
/*
if($_POST['grupo']=='SI'){
	$grupo = true;
}else{
	$grupo = false;
}
*/
$grupo = true;
if($Sede=='VRB'){
	$DSN='BQTO_S1';
}
else{
	$DSN='CARORA_S1';
}
SET_TIME_LIMIT(180);



// Carga librerias
include_once('ActivaError.php');// Activar Solo en produccion
include_once('Funciones.php');
include_once('odbcss_c.php'); //cliente odbc para Sql base para windows

// declaracíon de arreglos y  variables
//Pas_var(); // Paso de variables $_GET, $_POST, $_SESSION


//-------------------------------------------------------------------------
//5C.-  Transfiere datos de  Correos de Estudiantes Regulares
//-------------------------------------------------------------------------
$tipo_acceso="S";
include_once('Datos_Conexion.php');
$BD_datos_p =new ODBC_Conn($DSN,$user,$password);
if ($Sede =='VRB')	{
	$CONSULTA5 = "
			SELECT 
			CORREO_INST AS correo,
			NOMBRES as nombres,
			APELLIDOS AS apellidos,
			CLAVE_INIC_CORREO AS password,
			CI_E as cedula,
			C_UNI_CA
			FROM DACE002 
			WHERE CORREO_ESTATUS='R' AND CORREO_INST IS NOT NULL ORDER BY C_UNI_CA
			";
}else{
	$CONSULTA5 = "
			SELECT 
			CORREO_INST AS correo,
			NOMBRES as nombres,
			APELLIDOS AS apellidos,
			CLAVE_INIC_CORREO AS password,
			CI_E as cedula,
			C_UNI_CA
			FROM DACE002 
			WHERE 
			CORREO_ESTATUS='R' AND CORREO_INST IS NOT NULL ORDER BY C_UNI_CA
			";
			
}
	
//PRINT("<BR>".$CONSULTA5."<BR>");
		
$DatosEstR = $BD_datos_p->ExecSQL($CONSULTA5);
if ($BD_datos_p->status !="OK") { 
	$msg ='Error consulta tabla de Correos de estudiantes regulares activos';
	mensaje($msg);
	exit;
}else{
	
}
			
$Matr_EstR= $BD_datos_p->result;
unset($BD_datos_p->result);
$filas = sizeof($Matr_EstR);
if($filas<=0){
	$msg ='No existen Solicitudes de reincio de Claves';
	mensaje($msg);
?>
<head>
<title><?php echo $tProceso . $lapso; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Refresh" CONTENT="0;URL=../P10_SolicReinicioClv.php">
</head>
<?php
	exit;
}
/*
echo "<PRE>";
print_r($Matr_EstR);
echo "</PRE>";
*/


//echo "<BR>Recuperados $filas registros de  estudiantes regulares activos.";
$ruta='';


//------------------------------------------------
// Genera archivo para la actualización
//------------------------------------------------
$FecHora=date('ymdHi');
$fileNameCSV	='R-'.$Sede.'-'.$FecHora.'.csv';
$fileNameCSVG	='GR-'.$Sede.'-'.$FecHora.'.csv';

$filas=sizeof($Matr_EstR);
$columnas=sizeof($Matr_EstR[0]);

//$elCSV="";
$elCSV = "email address,first name,last name,password"."\n";
$elCSVG= "idcorreo,password,sede,cedula"."\n";
$f=0;

while ($f < $filas) {

	$pri_nom = '';$seg_nom = '';
	$Esp = $Matr_EstR[$f][5];
	if($Sede=='VRB'){
		switch ($Esp) {
			 case 1:
				 $Espec ='INN';
				 break;
			 case 3:
				 $Espec ='IMC';
				 break;
			 case 4:
				 $Espec ='IML';
				 break;

			 case 5:
				 $Espec ='IEL';
				 break;
			 case 6:
				 $Espec ='IET';
				 break;
			 case 7:
				 $Espec ='IQM';
				 break;
		 }
	}else{
		switch ($Esp) {
		 case 1:
			 $Espec ='TMC';
			 break;
		 case 2:
			 $Espec ='TET';
			 break;
		 case 3:
			 $Espec ='IML';
			 break;
		 case 4:
			 $Espec ='IRU';
			 break;
		}
	}
	
	sscanf ($Matr_EstR[$f][1], "%s %s",$pri_nom ,$seg_nom);
	$nomb  = ucfirst(strtolower($pri_nom)).' '.ucfirst(strtolower($seg_nom));
	//echo $nomb;


	$pri_ape = '';$seg_ape = '';
	sscanf ($Matr_EstR[$f][2], "%s %s",$pri_ape ,$seg_ape);
	$apell  = ucfirst(strtolower($pri_ape)).' '.ucfirst(strtolower($seg_ape));
	//echo $apell;

	$clave = $Matr_EstR[$f][3];
	$ci = $Matr_EstR[$f][4];
	
	if (strlen($Matr_EstR[$f][3] < 8)){
		$clave = str_pad($clave, 8, substr($clave, -1, 1), STR_PAD_RIGHT);
	}
	

	$elCSV.= "\"".$Matr_EstR[$f][0]."\"".',';
	$elCSV.= '['.$Sede.'-'.$Espec.'] '.trim($nomb).',';
	$elCSV.= trim($apell).',';
	$elCSV.= $clave.',';
	$elCSV = substr_replace ($elCSV, "\n", -1);
	
	$elCSVG.= "\"".$Matr_EstR[$f][0]."\"".',';
	$elCSVG.= $clave.',';
	$elCSVG.= $Sede.',';
	$elCSVG.= trim($ci).',';
	$elCSVG = substr_replace ($elCSVG, "\n", -1);
	
	$f++;
}

if($grupo){
	// Genera CSV de Grupos
	header("Content-type: application/vnd.ms-csv");  
	header("Content-Disposition: attachment; filename=$fileNameCSVG");  

	echo($elCSVG);//escribe en el archivo cada un de las filas del CSv
}else{
	// Genera CSV de Correos
	header("Content-type: application/vnd.ms-csv");  
	header("Content-Disposition: attachment; filename=$fileNameCSV");  

	echo($elCSV);//escribe en el archivo cada un de las filas del CSV
}


?>