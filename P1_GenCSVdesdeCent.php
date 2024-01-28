 <?php
//------------------------------------------------------------------
// P1_GenCSVdesdeCent.php
//------------------------------------------------------------------
// Proceso	N�	: 1
// Objetivo		: Descarga datos de estudiante desde base de datos 
//				  SQLbase en archivo con formato CSV, seg�n Sede 
//				  y Lapso.
// Proceso		:
//	1.- Permite seleccionar sede y Lapso 
//	2.- e invoca P1_CrearCSV.php que crea CSV
//
// Creditos:	Jos� Mujica
//------------------------------------------------------------------
//session_start();
//Establecer DSN seg�n la Sede que maneje la Localidad
if (!isset($_SESSION["Sede"])){
    $_SESSION['Sede'] = "VRP";
}

$Sede= $_SESSION['Sede'];


if($Sede=='VRP'){
	$_SESSION["DSN"] = "NINGRESO";
	//$_SESSION["DSN"] = "CENTURA-DACE";
}
else{
	$_SESSION["DSN"] = "CARORA_S1";
}
SET_TIME_LIMIT(180);

$DSN=$_SESSION["DSN"];
// fin de Establecer DSN
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>Sistema de Gesti�n de Correo estudiante - P1</TITLE>
  <META NAME="Generator" CONTENT="EditPlus">
  <META NAME="Jose Mujica" CONTENT="">  
  <META NAME="Keywords" CONTENT="">
  <META NAME="Description" CONTENT="">
  <META http-equiv=Content-Type content=text/html; charset=iso-8859-1>
	<link rel="stylesheet" href="./css/estilos.css" type="text/css" />
</HEAD>

<BODY>

 <?php   
	// Carga librerias
	//include_once('ActivaError.php');
	include_once('./include/Funciones.php');
	include_once('./include/odbcss_c.php'); //cliente odbc para Sql base para windows

	// declarac�on de arreglos y  variables
	Pas_var(); // Paso de variables $_GET, $_POST, $_SESSION
	
	// conexi�n a Base de Datos
	$tipo_acceso="S";
	include_once('./include/Datos_Conexion.php');
	$BD_datos_p =new ODBC_Conn($DSN,$user,$password);

	// Declaro arreglo para el control de seleccion de Sedes
	$arr_txt_Sede		=array('VRP',);
	$arr_val_Sede		=array('VRP');
	//-----------------------------------------------------------------
	// 0- Obtiene tabla de Lapsos para el control de Seleccion de Lapsos
	//-----------------------------------------------------------------

	$CONSULTA0="SELECT LAPSO_ACTUAL FROM RANGO_INSCRIPCION ";
	/*$CONSULTA0="SELECT LAPSO FROM EXPLIBRE ";*/

	
	$DatosLapso = $BD_datos_p->ExecSQL($CONSULTA0);
	if ($DatosLapso !="OK"){  
		$msg="Error BD  "."Consultando Lapsos";
		mensaje($msg);
		exit;
	}
	Else{
		$arr_Lapsos=Obtener_colum($BD_datos_p->result,0); //obtiene lapsos
		$Lapso = Max($arr_Lapsos); // determina lapso Actual
		unset($BD_datos_p->result); // destruye matriz de resultados
	}



	// Carga formulario
	if(!isset($_POST['Lapso'])){
	?>
	<div id="contenedor">
		<div id="encabezado"> 
			<img src="./img/banner.png" width="100%" height="128" border="0" alt="Correo-Estudiante">
		</div> <!-- fin encabezado-->
		
		<div id="contenidoprin">
		<div id="areatexto">
			<?php Formulario();?>
			</div><!-- fin areatexto-->
		</div><!-- fin contenidoprin-->
		<div id="pie">
			UNEXPO. La Universidad T�cnica del Estado Venezolano
		</div> <!-- fin pie -->
	 </div><!-- fin contenedor-->

	<?php
	}

?>


<?php
//===============================================//
//             FUNCIONES LOCALES				 // 
//===============================================//

//-----------------------------------------
function Formulario()
//-----------------------------------------
{
	global $seleLapso, $arr_Lapsos , $Lapso;
	global $Sede,$arr_txt_Sede ,$arr_val_Sede , $Sede;

	$seleLapso	=	frm_select('Lapso',$arr_Lapsos ,$arr_Lapsos, $Lapso) ; // Crea Selector de Lapsos
	$seleSede	=	frm_select('Sede',$arr_txt_Sede ,$arr_val_Sede ,  $Sede) ; // Crea Selector de sede
	

?>
		<div id="formulario"> <Center> 
			<FORM METHOD=POST ACTION="./include/P1_crearCSV.php"><!-- Invoca Crear CSV -->
			<FIELDSET>   
			<LEGEND >Descargar datos Estudiantes desde BD SQLBase a formato CSV</LEGEND> 
				<TABLE border = "0" width ="400"> 
					<TR> 
						<TD  width ="50%" height="24" align ="right"> <B> Sede:</B> </TD>
						<TD width="267" valign="top"> <?php echo "$seleSede" ; ?>   </TD> 
						<!-- muestra Caja de seleccion de Lapsos-->
					</TR>

					<TR> 
						<TD  width ="50%" height="24" align ="right"> <B> Lapso:</B> </TD>
						<TD width="267" valign="top"> <?php echo "$seleLapso" ; ?>   </TD> 
						<!-- muestra Caja de seleccion de Lapsos-->
					</TR>

				</TABLE>
			</FIELDSET><BR>
			<INPUT type="submit" value="Descargar" align = "center">
			
			<INPUT type="button" value="Regresar" onclick="location.href='./index.html';" > 	
			
			<br><a href="AyudaP1.html" title='Ayuda del Proceso N� 1'>
			<img src="img/ayuda.jpg" width="25%" height="15%" border="0" alt="">
			</a>
			
			</FORM>
		</div>

<?php
}


?>
</div>
</BODY>
</HTML>
