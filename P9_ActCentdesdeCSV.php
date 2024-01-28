<?php
session_start();
//------------------------------------------------------------------
// P9_ActCentdesdeCSV.php 
//------------------------------------------------------------------
// Proceso		:	8
// Objetivo		:	Actualizar campos CORREO_INST, CLAVE_INIC_CORREO 
//					de la tabla DACE002 de las BD locales 
//					utilizando el CSV actualizado en el proceso N° 7.
// proceso		:
//					1.- Selecciona el archivo CSV a Cargar 
//					2.- Recorre Cada de Linea del archivo CSV para 
//					grupos ir actualizando los campos pertinentes.
// Creditos:	José Mujica
//------------------------------------------------------------------

// Header
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
  <title>Sistema de Gestión de Correo estudiante - P8</title>
<link rel="stylesheet" href="./css/estilos.css" type="text/css" />
<body>
<?php

// Carga librerias necesarias
ini_set("./include/html_errors", false); 
include("./include/Funciones.php");  // muestra encabezado 

//Establecer los parametros de validación
	$nombre_archivo=''; //Nombre del archivo  a ser cargado
	$tipos_archivo = array("csv");
	$max_size = 1024*250; // establece el maximo tamaño del archivo a cargar

//  seleccionar el archivos CSV
if (!isset($_POST['upload'])){
	?>
	<div id="contenedor">
		<div id="encabezado"> 
			<img src="./img/banner.png" width="100%" height="128" border="0" alt="Correo-Estudiante">
		</div> <!-- fin encabezado-->
		
		<div id="contenidoprin">
		<div id="areatexto">
			<?php $archivo=SelecArchivo();?>
			</div><!-- fin areatexto-->
		</div><!-- fin contenidoprin-->
		<div id="pie">
			UNEXPO. La Universidad Técnica del Estado Venezolano
		</div> <!-- fin pie -->
	</div><!-- fin contenedor-->

	<?php
} 

$archivo_valido=True;
if (isset($archivo)){
	$totalRegistros=0;	
	
	// Recupera información del archivo a subir
	$archivo_temporal=$_FILES['userfile']['tmp_name']; 
	$nombre_archivo = $_FILES['userfile']['name'];
	$tipo_archivo = $_FILES['userfile']['type'];
	$tamano_archivo = $_FILES['userfile']['size'];
	$grupo= substr($nombre_archivo,2,3);
	$inicial=substr($nombre_archivo,0,1);
	$extension=substr ($nombre_archivo,strpos($nombre_archivo,"csv"),3);

	echo "<BR><==================< Cargando Archivo ".$nombre_archivo." >==================>";

/*
		echo "<pre>";  print_r($_FILES); echo "</pre>";

		echo "<BR>Archivo Temporal:=> ".$archivo_temporal;
		echo "<BR>Archivo:==========> ".$nombre_archivo;
		echo "<BR>Tipo de Archivo===> ".$tipo_archivo;
		echo "<BR>Tamaño archivo ===> ".$tamano_archivo;
		echo "<BR>Grupo:============> ".$grupo;
		echo "<BR> Inicial Grupo:===> ".$inicial;
		echo "<BR>extension :========>".$extension."<===";
		echo "<BR> posicision :======>".strpos($nombre_archivo, "csv");
		echo "<pre>";  print_r($_FILES); echo "</pre>";
*/

	if ($nombre_archivo=''){
		//$msg="Debe seleccionar un archivo con extension csv. ";
		mensaje($msg);
		unset($_POST['upload']);
		$archivo_valido=False;
	 }	
	//Valida si es archivo de Grupo	 
	if ($inicial!='G'){
		$msg="El archivo Seleccionado no es un archivo de Grupo. ";
		mensaje($msg);
		unset($_POST['upload']);
		$archivo_valido=False;
	 }
	//Valida que el archivo seleccionado es un csv
	if ($extension!="csv"){
	   $msg="Error. La extensión no es correcta";
	   mensaje($msg);
	   unset($_POST['upload']);
	   $archivo_valido=False;
	}
	if (($tamano_archivo > $max_size)){
	   $msg="se permiten archivos de $max_size Kb máximo.";
	   mensaje($msg);
	   unset($_POST['upload']);
	   $archivo_valido=False;
	}
	if($archivo_valido){
		$RegAct=ActDatos($archivo);
		//$RegAct--;
		//$totalRegistros--;
		//echo "<BR>***"."Actualizados $RegAct Registros de un total de $totalRegistros"."****<BR>";
		echo "<BR><===< Actualizados ".$RegAct." Registros de un total de ".$totalRegistros.">===>";
	}else{
		
	}
	?> <a href="<?php echo $_SERVER['PHP_SELF']; ?>"><BR>Regresar</a> <?php	
}
	


//------------------------------------------------------------------
// Fin de P8_ActCentdesdeCSV.php 
//------------------------------------------------------------------




/******************************************************************/
/*						Funciones								  */
/******************************************************************/

//------------------------------------------------------------------
function ActDatos($archivo){
//------------------------------------------------------------------
// Recorrer el archivo CSV y actualizar registro en la tabla 
// correos de la base DACE002(Centura)
// 
//------------------------------------------------------------------
global $totalRegistros, $grupo;
	include_once('./include/odbcss_c.php'); 

	$totalRegistros=0;
	$RegAct=0;	
	$tipo_acceso="U";
	include_once('./include/Datos_Conexion.php');
	//$Sede	=substr ($data[2], 2,3); 
	$DSN=$grupo;
	//echo $DSN; //exit;
	//Conexion a Base de datos de acuerdo

	switch ($grupo) {
		/* case 'nch':
			 	// conexión a Base de Datos Local
			 $DSN='';
			 break;
		 case 'ngu':
			 $DSN='';
			 break;
		 case 'VRB':
			 $DSN='BQTO_S1';
			//$BD_datos_p =new ODBC_Conn("BQTO_S1","USUARIO2","USUARIO2");
			//$BD_datos_p =new ODBC_Conn("BQTO_S1","USUARIO2","USUARIO2");
			 break;
		 case 'NCa':
			 $DSN='CARORA';
			 //$BD_datos_p =new ODBC_Conn("CARORA_S1","USUARIO2","USUARIO2");
			 break;
		 case 'vrp':
			 $DSN='';
			 break;*/

		/*case 'VRP':
			$titulo = "UNEXPO NUCLEO PUERTO ORDAZ ING"."<BR>";
			$DSN='CENTURA-DACE';
			break;
		/*case 'POZ_TSU':
			$titulo = "UNEXPO NUCLEO PUERTO ORDAZ TSU"."<BR>";
			$DSN='CENTURA-TSU';
			break;*/
		case 'VRP':
			$titulo = "UNEXPO NUCLEO PUERTO ORDAZ POSTGRADO"."<BR>";
			$DSN='CENTURA-POSTGRADO';
			break;
		/*case 'POZ_ART':
			$titulo = "UNEXPO NUCLEO PUERTO ORDAZ PROSECUCION"."<BR>";
			$DSN='CENTURA-ART';
			break;*/
		default:
			$msg="Error. Sede no está definida";
			mensaje($msg);
	}

	$BD_datos_p =new ODBC_Conn($DSN,$user,$password);
	$fp = fopen ($archivo,"r"); // abre el archivo CSV
	if($data = fgetcsv ($fp, 1000, ","))
	{
		//Valida la primera línea coincida con los nombres y orden de los campos
		$campos =array('idcorreo','password','sede','cedula');
/*		echo"<pre>";
		print_r($campos);
		echo"</pre>";
		echo"<pre>";
		print_r($data);
		echo"</pre>";
*/
		$encabez=explode (",", $data[0]);
		for($i=0;$i<3;$i++){ 
		//	echo "<br>***".$i."***<br>";
		//echo "<br>***".$campos[$i]."***<br>";
		//echo "<br>***".$data[$i]."***<br>";
			if($data[$i]!=$campos[$i]){
				$msg="Error. Campos no coindicen en nombres o en orden.";
				mensaje($msg);
				unset($_POST['upload']);
				?> <a href="<?php echo $_SERVER['PHP_SELF']; ?>"><BR>Regresar</a> <?php	
				exit;
			}
		}
		while ($data = fgetcsv ($fp, 1000, ",")) {
	//	$registro=explode (",", $data[0]);
	/*
			echo "<PRE>";
			print_r($data);
			echo "</PRE>";
	*/
			$email	=$data[0];
			$clave	=$data[1];
			$Sede	=$data[2];
			$ced	=$data[3];
		
			if($email!='correo'){
				$consulta= "UPDATE DACE002 SET CORREO_INST='".$email."', CLAVE_INIC_CORREO='".$clave."' , CORREO_ESTATUS='A'
				WHERE CI_E='".$ced."' ";//AND CORREO_ESTATUS IS NULL";
				$DatosEst = $BD_datos_p->ExecSQL($consulta);
				//PRINT($consulta);
				if ($DatosEst !="OK"){  
					$msg="Error. Actualizando el registro $RegAct";
					mensaje($msg);
					
				}else{
					if($BD_datos_p->fmodif != 0){
					echo "<BR>Actualizado el registro del estudiante con cédula ".$ced." y correo ". $email;
					}
					$RegAct=$RegAct+$BD_datos_p->fmodif;// No debe incrementar, debe sumar el registro si es actualizado
					
				}		

			}
			$totalRegistros++;
		}
	}
	fclose($fp); // cierra el archivo CSV

	return $RegAct;
}






//------------------------------------------------------------------
function SelecArchivo(){
//------------------------------------------------------------------
// Permite seleccionar el archivos CSV
//------------------------------------------------------------------
	global $max_size, $userfile;
	include ("./include/upload_class.php"); //Libreria que carga archivo en temporal y guarda el archivo
	$my_upload = new file_upload; // instancia la clase
	//MuestraDatosArchiuvo();
	if(isset($_POST['Submit'])) {

		$my_upload->the_temp_file = $_FILES['userfile']['tmp_name'];
		$my_upload->the_file = $_FILES['userfile']['name'];
		$my_upload->http_error = $_FILES['userfile']['error'];
		$new_name = (isset($_POST['name'])) ? $_POST['name'] : "";
	if ($my_upload->upload($new_name)) {
		//echo "fino"; 
		//$my_upload->move_upload($new_name, "/nuevo.cvs");
		
	 }
	
	 return $my_upload->the_temp_file;

	}
	?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>Actualizar correos y claves desde CSV a Centura </title>
	<style type="text/css">
	<!--
	label {
		float:left;
		display:block;
		width:120px;
	}
	input {
		float:left;
	}
	-->
	</style>
	</head>

	<body>
<div id="formulario">
	
	

	<form name="form1" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<FIELDSET>   
	<LEGEND >Actualizar datos de correos desde CSV a BD Locales</LEGEND> 
	<p>Tama&ntilde;o M&aacute;ximo permitido = <?php echo $max_size; ?> bytes.</p>
	  <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_size; ?>"><br>
	  <label for="userfile">Archivo de CSV:</label><input type="file" name="userfile" size="30"><br clear="all">
	  <input name="check" type="hidden" value="y" checked><br clear="all">
	 </FIELDSET>   
	  <input style="margin-left:120px;" type="submit" name="Submit" value="Cargar">&nbsp;&nbsp;
	  <input type=button value=Regresar onclick="location.href='./index.html';" > 		
	
	  <br><a href="AyudaP9.html" title="Ayuda del Proceso N° 9">
		<img src="img/ayuda.jpg" width="25%" height="15%" border="0" alt="">
	  </a>
	</form>
</div>	
	<br clear="all">
	<p><?php echo $my_upload->show_error_string(); ?></p>
	<?php if (isset($info)) echo "<blockquote>".nl2br($info)."</blockquote>"; 

}
//------------------------------------------------------------------
// Aqui termina function SelecArchivo(){
//------------------------------------------------------------------

//------------------------------------------------------------------
function MuestraDatosArchivo(){
//------------------------------------------------------------------
 
  
  // Recupera información del archivo a subir

		$archivo_temporal=$archivo; 
		$nombre_archivo = $_FILES['userfile']['name'];
		$tipo_archivo = $_FILES['userfile']['type'];
		$tamano_archivo = 
		$grupo= substr($nombre_archivo,2,3);

	echo "Nombre del archivo Seleccionado==> ". $_FILES['userfile']['name'];
	echo "Nombre del archivo temporal======> ". $_FILES['userfile']['name'];
	echo "Nombre del directorio descarga===> ". $my_upload-> $upload_dir;
	echo "Nombre del archivo temporal======> ". $my_upload-> $the_temp_file;
	echo "Nombre del archivo temporal======> ". $my_upload-> $do_filename_check;
	echo "Nombre del archivo temporal======> ". $my_upload-> $max_length_filename;
	echo "Nombre del archivo temporal======> ". $my_upload-> $extensions;
	echo "Nombre del archivo temporal======> ". $my_upload-> $ext_string;
	echo "Nombre del archivo temporal======> ". $my_upload-> $language;
	echo "Nombre del archivo temporal======> ". $my_upload-> $http_error;
	echo "Nombre del archivo temporal======> ". $my_upload-> $rename_file;
	echo "Nombre del archivo temporal======> ". $my_upload-> $file_copy;
	echo "Nombre del archivo temporal======> ". $my_upload-> $create_directory;
	echo "Nombre del archivo temporal======> ". $my_upload-> $message;
	echo "Nombre del archivo temporal======> ". $my_upload-> $message;
	echo "Nombre del archivo temporal======> ". $my_upload-> $message;
//------------------------------------------------------------------

}
?>