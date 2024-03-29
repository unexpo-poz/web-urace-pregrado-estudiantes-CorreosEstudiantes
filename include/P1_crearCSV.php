<?php
 session_start();
//------------------------------------------------------------------
// P1_CrearCSV.php
//------------------------------------------------------------------
// Proceso N�		:	1
// Objetivo			:	Descarga datos de la base de datos de estudiante
//						de la tabla DACE002 de las BD DACE y CARORA en
//						archivo con formato CSV, seg�n Sede y Lapso. Es
//						invocado por P1_GenCSVdesdeCent.php
//
// Creditos:	Jos� Mujica
//------------------------------------------------------------------


$Sede= $_POST["Sede"];
$Lapso= $_POST['Lapso'];
if($Sede=='VRP'){
	$DSN='NINGRESO';
	//$DSN='CENTURA-DACE';
}
/*if($Sede=='POZ_TSU'){
	$DSN='CENTURA-TSU';
}*/
/*if($Sede=='VRP'){
	$DSN='CENTURA-POSTGRADO';
}
if($Sede=='VRP'){
	$DSN='NINGRESO';
}*/
SET_TIME_LIMIT(180);



// Carga librerias
include_once('ActivaError.php');// Activar Solo en produccion
include_once('Funciones.php');
include_once('odbcss_c.php'); //cliente odbc para Sql base para windows

// declarac�on de arreglos y  variables
//Pas_var(); // Paso de variables $_GET, $_POST, $_SESSION


//-------------------------------------------------------------------------
//5C.-  Transfiere datos de  Correos de Estudiantes Regulares
//-------------------------------------------------------------------------
$tipo_acceso="S";
include_once('Datos_Conexion.php');
$BD_datos_p =new ODBC_Conn($DSN,$user,$password);
if ($Sede =='VRP')	{
	
	$CONSULTA5 = "
				SELECT DISTINCT NOMBRES||' '||NOMBRES2, APELLIDOS||' '||APELLIDOS2,CI_E,'".$Sede."' AS SEDE,
				@DECODE(C_UNI_CA,'2','IMC','3','IET','4','IML','5','IEL','6','IIN') AS CARRERA
				FROM DACE002 A
				WHERE A.ESTATUS_E IN('1') AND lapso_in='2022-1' AND CORREO_INST IS NULL
			";
	
	
	/* CONSULTA PERMANENTE*/
	
	 /*$CONSULTA5 = "
				SELECT DISTINCT NOMBRES||' '||NOMBRES2, APELLIDOS||' '||APELLIDOS2,CI_E,'".$Sede."' AS SEDE,
				@DECODE(C_UNI_CA,'2','IMC','3','IET','4','IML','5','IEL','6','IIN') AS CARRERA ,CORREO1
				FROM DACE002 A, DACE006 B 
				WHERE A.EXP_E=B.EXP_E AND A.ESTATUS_E IN('1')and lapso_in='2017-1' AND STATUS IN ('7','A') AND CORREO_INST IS NULL
			";*/
	/*$CONSULTA5 = "
				SELECT DISTINCT NOMBRES, APELLIDOS,CI_E,'".$Sede."' AS SEDE,
				@DECODE(C_UNI_CA,'1','IIN','2','IST','3','IMC','4','IML','5','IEL','6','IET','7','IQM') AS CARRERA ,CORREO_ALTER
				FROM DACE002 A, DACE006 B 
				WHERE A.EXP_E=B.EXP_E AND B.LAPSO='".$Lapso."' AND STATUS IN ('7','9') AND CORREO_INST IS NULL
			";*/
	/*$CONSULTA5 = "
				SELECT DISTINCT NOMBRES, APELLIDOS,CI_E,'".$Sede."' AS SEDE,
				@DECODE(C_UNI_CA,'EC','EEC','EE','EEE','GM','EGM','IA','EIA','PR','EPR','PS','EPS','ER','EER','TD','ETD','IE','MET','EL','MEL','II','MIN','MM','MMC','MT','MML','MI','MMI','ES','EES') AS CARRERA ,CORREO_ALTER
				FROM DACE002 A
				WHERE A.ESTATUS_E IN('1')  AND CORREO_INST IS NULL
			";*/
}else{
	$CONSULTA5 = "
				SELECT DISTINCT NOMBRES||' '||NOMBRES2, APELLIDOS||' '||APELLIDOS2,CI_E,'".$Sede."' AS SEDE,
				@DECODE(C_UNI_CA,'2','IMC','3','IET','4','IML','5','IEL','6','IIN') AS CARRERA
				FROM DACE002 A, DACE006 B 
				WHERE A.EXP_E=B.EXP_E AND A.ESTATUS_E IN('1') and lapso_in='2022-1' AND STATUS IN ('7','A') AND CORREO_INST IS NULL
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
	$msg ='No existen registros de estudiantes regulares activos';
	mensaje($msg);
?>
<head>
<title><?php echo $tProceso . $lapso; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Refresh" CONTENT="0;URL=../P1_GenCSVdesdeCent.php">
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
$FecHora=date('ymdHi');
$fileNameCSV=$Sede.$FecHora.'.CSV';

$filas=sizeof($Matr_EstR);
$columnas=sizeof($Matr_EstR[0]);

$elCSV="";
$elCSV= "nombres,apellidos,cedula,sede,carrera,correoalternativo\n";
$f=0;
while ($f < $filas) {
	$c=0;

	for ($c = 0; $c < $columnas; $c++){	
		$elCSV.= "\"".$Matr_EstR[$f][$c]."\"".',';		// Arma cada una de las filas del CSV*/
	}
	$elCSV=substr_replace ($elCSV, "\n", -1);
	$f++;
	
}

//echo($elCSV);//escribe en el archivo cada un de las filas del CSv

header("Content-type: application/vnd.ms-csv");  
header("Content-Disposition: attachment; filename=$fileNameCSV");  

echo($elCSV);//escribe en el archivo cada un de las filas del CSv

?>