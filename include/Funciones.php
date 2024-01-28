<?php
//----------------------------------------------------------------------------------------------------------
function vaya_A($Archivo){
//----------------------------------------------------------------------------------------------------------
// Va al archivo
?>
<head>
<title><?php echo $tProceso . $lapso; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Refresh" CONTENT="0;URL=../<?php echo $archivo; ?>">
</head>
<?php
return;
}
//----------------------------------------------------------------------------------------------------------
function Vermatriz($matriz)
// muestra el contenido de matriz
//----------------------------------------------------------------------------------------------------------
{
	echo "<PRE>";
	echo "PRINT_R($matriz)";
	echo "</PRE>";
return;
}

//----------------------------------------------------------------------------------------------------------
function mensaje($msg)
// funcion que muestra mensaje en javascript
// desde una variable php
//----------------------------------------------------------------------------------------------------------
{
	echo '<script languaje="JavaScript"> var mensaje="'.$msg.'"; 
		alert(mensaje);
	</script>';
return;
}
//----------------------------------------------------------------------------------------------------------
function Total($matriz,$colum)
//----------------------------------------------------------------------------------------------------------
// Totaliza valores de  columna de una matriz
{	
	//echo "totalizo la columna: "."$colum"."<BR>";
	$total=0;
	$n=0;
	$items=count($matriz);
	while ($n < $items) 
	{   $valor =($matriz[$n][$colum]);
	    $total= $total+$valor;
		$n++;
	}
	return $total;
}
//----------------------------------------------------------------------------------------------------------
function porcentajes($matriz,$colum)
//----------------------------------------------------------------------------------------------------------
// Calcula porcentaje de cada valor  en la columna con respecto al total de columna
{
	$total=0;
	$total=Total($matriz,$colum);
	$n=0;
	$items=count($matriz);
	while ($n < $items) 
	{   $valor =($matriz[$n][$colum]);
		if ($total!=0)
			{
				$porcentaje[$n] = (($valor*100)/$total);
			}
		else
			{
				$porcentaje[$n] =0;
			}
		$n++;
	}
		
	

	return $porcentaje; 
}
//----------------------------------------------------------------------------------------------------------
function Agregaporc($matriz,$porcentajes,$colum)
//----------------------------------------------------------------------------------------------------------
// Agrega columna con porcentajes a matriz
{

	$n=0;
	$filas	=count($matriz);
	//echo " agrego porcentaje columna: "."$colum"."<BR>";

	while ($n < $filas) 
	{   
		$matriz[$n][$colum]=  sprintf ("%01.1f",$porcentajes[$n])."%";
		$n++;
	}

	return $matriz; 
}

//----------------------------------------------------------------------------------------------------------
function BuscIndice($matriz, $valor)
//----------------------------------------------------------------------------------------------------------
// Busca valor en la matrix y devuelve la posicion(indice)
{
    $rows = count($matriz);
	for ($i = 0; $i <= $rows; $i++) 
		{
			if ($matriz[$i] == $valor) {Return $i;}
			
		}
}
//----------------------------------------------------------------------------------------------------------
function Pas_var($datos_recibir="")
//----------------------------------------------------------------------------------------------------------
// Recibe variables Post

//function recibe_post($datos_recibir="")
{ 
   if ($datos_recibir==""){ 
      foreach($_POST as $nombre_campo => $valor){ 
         $asignacion = "\$GLOBALS[\"" . $nombre_campo . "\"]='" . $valor . "';"; 
         eval($asignacion); 
      } 
   }else{ 
      //es que recibo por par�metro la lista de campos que deseo recibir 
      $campos = explode(",", $datos_recibir); 
      foreach($campos as $nombre_campo){ 
         $asignacion = "\$GLOBALS[\"" . $nombre_campo . "\"]=\$_POST[\"" . $nombre_campo . "\"];"; 
         eval($asignacion); 
      } 
   } 
} 

//----------------------------------------------------------------------------------------------------------
function fechasistema()
//----------------------------------------------------------------------------------------------------------
//retorna la Fecha del Sistema en el idioma que este instalado el servidor
	{ 
	$dias = array("Monday"    => "Lunes"     ,"Lunes"     => "Monday", 
				  "Tuesday"   => "Martes"    ,"Martes"    => "Tuesday", 
				  "Wednesday" => "Miercoles" ,"Miercoles" => "Wednesday", 
				  "Thursday"  => "Jueves"    ,"Jueves"    => "Thursday", 
				  "Friday"    => "Viernes"   ,"Viernes"   => "Friday", 
				  "Saturday"  => "Sabado"    ,"Sabado"    => "Saturday", 
				  "Sunday"    => "Domingo"   ,"Domingo"   => "Sunday" ); 

	$mes = array("January"   =>"Enero"      ,"Enero"      => "January", 
				 "February"  =>"Febrero"    ,"Febrero"    => "February", 
				 "March"     =>"Marzo"      ,"Marzo"      => "March", 
				 "April"     =>"Abril"      ,"Abril"      => "April", 
				 "May"       =>"Mayo"       ,"Mayo"       => "May", 
				 "June"      =>"Junio"      ,"Junio"      => "June", 
				 "July"      =>"Julio"      ,"Julio"      => "July", 
				 "August"    =>"Agosto"     ,"Agosto"     => "August", 
				 "September" =>"Septiembre" ,"Septiembre" => "September", 
				 "October"   =>"Octubre"    ,"Octubre"    => "October", 
				 "November"  =>"Noviembre"  ,"Noviembre"  => "November", 
				 "December"  =>"Diciembre"  ,"Diciembre"  => "December"); 
	$fecha = $dias[date("l")] . ", " .date("d"). " de ". $mes[date("F")]. " ".date("Y"); 
	return $fecha; 
}
//----------------------------------------------------------------------------------------------------------
//- Funciones auxiliares
//----------------------------------------------------------------------------------------------------------
function walk_tolower(&$val)
//----------------------------------------------------------------------------------------------------------
// Pasa a min�sculas 
{
	$val=strtolower($val);
}
//----------------------------------------------------------------------------------------------------------
function array_lower($a_arr)
//----------------------------------------------------------------------------------------------------------
// Convierte a minuscula los elementos del arreglo
{
	array_walk($a_arr, 'walk_tolower');
	return $a_arr;
}
//----------------------------------------------------------------------------------------------------------
function inicTitulo($DSN)
//----------------------------------------------------------------------------------------------------------
{	
	$titulo ="";
	switch ($DSN) 
		
	{
		/*case 'BQTO':
			$titulo = "VICERRECTORADO BARQUISIMETO"."<BR>";
			break;
		case 'CARORA':
			$titulo = "UNEXPO NUCLEO CARORA"."<BR>";
			break;
		case 'FACT':
			$titulo = "UNEXPO FACT"."<BR>";
			break;
		case 'DIP':
			$titulo = "POSTGRADO"."<BR>";
			break;*/
		case 'POZ':
			$titulo = "UNEXPO NUCLEO PUERTO ORDAZ ING"."<BR>";
			break;
		case 'POZ_TSU':
			$titulo = "UNEXPO NUCLEO PUERTO ORDAZ TSU"."<BR>";
			break;
		case 'POZ_POST':
			$titulo = "UNEXPO NUCLEO PUERTO ORDAZ POSTGRADO"."<BR>";
			break;
		case 'POZ_ART':
			$titulo = "UNEXPO NUCLEO PUERTO ORDAZ PROSECUCION"."<BR>";
			break;

	}
	Return $titulo;
}
//----------------------------------------------------------------------------------------------------------
  function imprime_tabla($titulo,$h,$data)//,$invoca
//----------------------------------------------------------------------------------------------------------
{
    $rows = count($data);
    $cols = count($h);

	Print("<BR>");
	Print("<BR>");
    print "<table width =\"525\" align=\"left\" border=\"0\" id=\"data\" cellspacing=\"2\" cellpadding=\"5\" >";
    print "<tr>\n";
	print "<th colspan=\"$cols \"  class=\"cielo\"><font class=\"negro\">".$titulo."</font></th>\n";
    print "<tr>\n";
    foreach($h as $hc)
		{
		print "<td  class=\"cielo\"><font class=\"negro\">".$hc."</font></td>\n";

		}
    print "</tr>\n";
    print "<tr>\n";
    $listc=false;
    foreach($data as $dr)
	{
        if ($listc) $estilo="blanco"; else $estilo="gris";
        foreach($dr as $dc)
		{   
			if (strrpos('01234567890',trim($dc))) $justificado="right";else $justificado= "left";
			print "<td width =\"*\"  class=\"".$estilo."\" align=\"$justificado\"><font class=\"negro\">".$dc."</font></td>\n";
		}
        $listc =!$listc;
        print "</tr>\n";
	}
	if($cols >=2)
	{	
	$justificado="right";
	$cspan=$cols-2;

	print "<td colspan=\"$cspan\" bgcolor=\"#99CCFF\" align=\"left\">"."TOTALES"."</font></td>\n";
	print "<td bgcolor=\"#99CCFF\" align=\"$justificado\">".Total($data,$cols-2)."</font></td>\n";
	print "<td bgcolor=\"#99CCFF\" align=\"$justificado\">".round(Total($data,$cols-1))."%"."</font></td>\n";

	}
    print "</table>\n";
}

//----------------------------------------------------------------------------------------------------------
function listar_matriz_asociada($mititulo, $micabecera,$mimatriz)
//----------------------------------------------------------------------------------------------------------
// Lista matriz Asociada
{
	$rows = count($mimatriz);
    $cols = count($micabecera);

	print "<table align=\"center\" border=\"0\" id=\"data\" cellspacing=\"2\" cellpadding=\"1\">";
    print "<tr>\n";
	print "<th colspan=\"$cols \"  class=\"cielo\"><font class=\"negro\">".$mititulo."</font></th>\n";
	print "<tr>\n";

    foreach($micabecera as $hc)

	{
		print "<td class=\"cielo\"><font class=\"negro\">".$hc."</font></td>\n";
	}
    print "</tr>\n";
    print "<tr>\n";
    $listc=false;

	// Recorro los elementos de la matriz asociada
	while ($elemento = each($mimatriz))
	{
        if ($listc) $estilo="blanco"; else $estilo="gris";
		print "<td nowrap class=\"".$estilo."\"><font class=\"negro\">"."$elemento[key]"."</font></td>\n";
		print "<td nowrap class=\"".$estilo."\"><font class=\"negro\">"."$elemento[value]"."</font></td>\n";
		$listc =!$listc;
		print "</tr>\n";
	}
	print "</table>\n";
}

//----------------------------------------------------------------------------------------------------------
Function Obtener_colum($Matriz_Bi,$colum)
//----------------------------------------------------------------------------------------------------------
// Obtiene arreglo columna de matriz Bidemensional 
{  
	$n=0;
	$items=count($Matriz_Bi);
	while ($n < $items) 
	{
		$columna[$n] =($Matriz_Bi[$n][$colum]);
		$n++;
	}
	return $columna;
}

//----------------------------------------------------------------------------------------------------------
Function Matr_Bi_Uni($Matriz_Bi)
//----------------------------------------------------------------------------------------------------------
// Pasa una matriz Bidemensional a Unidimensional
{  
	$n=0;
	$items=count($Matriz_Bi);
	while ($n < $items) 
	{
		$Matriz_Uni[$n] =($Matriz_Bi[$n][0]);
		$n++;
	}
	return $Matriz_Uni;
}

//----------------------------------------------------------------------------------------------------------
function frm_select($name, $arr_txt, $arr_vals, $default='', $extra_tag='')
//----------------------------------------------------------------------------------------------------------
// Funci�n que muestra  un control de Seleccion
{
	$tmp="<Select name='$name' $extra_tag >";
	$items=count($arr_txt);
	if($items!=count($arr_vals)) return $tmp."<option>ERR! en el array de valores</select>";
	for($i=0;$i<$items;$i++){
		$sel=' selected';
		$val=$arr_vals[$i];
		if(is_array($default))
		{
			if(!in_array( strtolower($val), array_lower($default) )) $sel='';
		}
		else
		{  
			if(!eregi($val,$default)) $sel='';
		}
	$tmp.="<option value='$val'$sel>".$arr_txt[$i]."</option>";
	}
	return $tmp.'</select>';
}
//----------------------------------------------------------------------------------------------------------
function frm_check($name, $ck_val, $var_in='', $extra_tag='')
//----------------------------------------------------------------------------------------------------------
// Funcion que crea un  control ChekBox
//Si se le pasa una variable por $var_in y coincide con $ck_val, se selecciona
{
	$ck='';
	if(strtolower($ck_val)==strtolower($var_in)) $ck=' checked';
	return "<input type=checkbox name='$name' value='$ck_val'$extra_tag$ck>";
}

//----------------------------------------------------------------------------------------------------------
function frm_list($name,$size,  $arr_txt, $arr_vals, $default='', $extra_tag='')
//----------------------------------------------------------------------------------------------------------
// Funcion que crea una lista  de tama�o visible = $size,  lo dem�s es igual que frm_select
{
	return frm_select($name, $arr_txt, $arr_vals, $default, "size=$size $extra_tag");
}

//----------------------------------------------------------------------------------------------------------
function frm_list_multi($name, $size, $arr_txt, $arr_vals, $default='', $extra_tag='')
//----------------------------------------------------------------------------------------------------------
// Funcion que crea una lista de  selecci�n multiple, como valores seleccionados se puede pasar un array
{
	return frm_list($name."[]", $size, $arr_txt, $arr_vals, $default, "multiple $extra_tag");
}


//----------------------------------------------------------------------------------------------------------
function frm_radio($name, $val, $var_in='', $extra_tag='')
//----------------------------------------------------------------------------------------------------------
// Funcion que crea un radio boton, 
// Si se le pasa una variable por $var_in y coincide con $ck_val, se selecciona
 
{
	$ck='';
	if(strtolower($val)==strtolower($var_in)) $ck=' checked';
	return "<input type=radio name='$name' value='$val'$extra_tag$ck>";
}

//----------------------------------------------------------------------------------------------------------
function frm_text($name, $val, $size, $max_length, $extra_tag='')
//----------------------------------------------------------------------------------------------------------
// funcion que crea un TextBox
{
	return "<input type=text name='$name' size='$size' maxlength='$max_length' value='$val'$extra_tag>";
}

//----------------------------------------------------------------------------------------------------------
function frm_password($name, $val, $size, $max_length, $extra_tag='')
//----------------------------------------------------------------------------------------------------------
// Funcion que crea un Password
{
	return "<input type=password name='$name' size='$size' maxlength='$max_length' value='$val'$extra_tag>";
}

//----------------------------------------------------------------------------------------------------------
function edad($fecha_nac)
//----------------------------------------------------------------------------------------------------------
// Funcion que calcula la edad
//Esta funcion toma una fecha de nacimiento 
//en formato aaaa/mm/dd y calcula la edad en n�meros enteros
{
	$dia=date("j");
	$mes=date("n");
	$anno=date("Y");

	//descomponer fecha de nacimiento
	$dia_nac=substr($fecha_nac, 8, 2);
	$mes_nac=substr($fecha_nac, 5, 2);
	$anno_nac=substr($fecha_nac, 0, 4);

	if($mes_nac>$mes){
		$calc_edad= $anno-$anno_nac-1;
	}else{
		if($mes==$mes_nac AND $dia_nac>$dia){
			$calc_edad= $anno-$anno_nac-1;  
		}else{
			$calc_edad= $anno-$anno_nac;
		}
	}
	return $calc_edad;
}
//----------------------------------------------------------------------------------------------------------
function escribir_cabeceras ($mimatriz)
//----------------------------------------------------------------------------------------------------------
// Funci�n que lista las claves de una matriz asociativa
{
      echo "<tr>\n";
      while ($elemento = each($mimatriz))
         echo "<th>$elemento[1]</th>\n";
      echo "</tr>\n";
}

//----------------------------------------------------------------------------------------------------------
// Funci�n que lista las claves de una matriz 
//----------------------------------------------------------------------------------------------------------
   function listarArr1($mimatriz,$micabecera, $mititulo)
//----------------------------------------------------------------------------------------------------------
{
	//calculo numero de filas y columas
	$nfilas=count($mimatriz); 
	if ($nfilas != 1) 
	{
		$ncolumnas=count($mimatriz[1]); 
	}
	// Escribo el titulo de la tabla
	echo "<TABLE BORDER=3 ALIGN=CENTER>\n";
	$ncolumnas=count($mimatriz[0]);
	echo "<TH colspan=$ncolumnas><CENTER><B>$mititulo</B></CENTER> </TH>";
	echo "</TR>\n";
		
	
	// Se escriben los datos de las cabeceras de las columnas
	escribir_cabeceras($micabecera);
	// Recorro los elementos de la matriz indexada
	for ($i = 0; $i < count($mimatriz); $i++)
	{
		echo "<TR>\n";
		// Recorro los elementos de la matriz asociativa
		while ($elemento = each($mimatriz[$i]))
		{
			echo "<TD >$elemento[1]</TD>\n";
			echo "</TR>\n";
		}
	}
	echo "</TABLE>\n";
}

//----------------------------------------------------------------------------------------------------------
    function imprime_tabla1($h,$data)
//----------------------------------------------------------------------------------------------------------
{
	$rows = count($data);
	$cols = count($h);
	print "<table align=\"center\" border=\"0\" id=\"data\" cellspacing=\"2\" cellpadding=\"1\">";
	print "<tr>\n";
	foreach($h as $hc)
		{
			print "<td class=\"cielo\"><font class=\"negro\">".$hc."</font></td>\n";
		}
	print "</tr>\n";
	print "<tr>\n";
	$listc=false;
	foreach($data as $dr)
	{
		if ($listc) $estilo="blanco"; else $estilo="gris";
		$dc = key($dr);
		if(is_null($dc)) $dc="&nbsp;"; 
		print "<td nowrap class=\"".$estilo."\"><font class=\"negro\">".$dc."</font></td>\n";
		$dc = current($dr);
		if(is_null($dc)) $dc="&nbsp;"; 
		print "<td nowrap class=\"".$estilo."\"><font class=\"negro\">".$dc."</font></td>\n";
		$listc =!$listc;
		print "</tr>\n";
	}
	print "</table>\n";
}
//----------------------------------------------------------------------------------------------------------
function Mostrar_matriz_indexada($matriz)
//----------------------------------------------------------------------------------------------------------
{
	//mostrar contenido
	$nro_elementos=count($matriz);
	$i=0;
	while($i<=$nro_elementos-1)
		{
			print("$matriz[$i]"."<BR>");
			$i++;
		}
}
//----------------------------------------------------------------------------------------------------------
function Mostrar_m_Asoc($matriz)
//----------------------------------------------------------------------------------------------------------
{
//mostrar contenido asociada
echo "<TABLE BORDER=0 ALIGN=CENTER>\n";
foreach($matriz as $clave=>$elemento)
	{
			echo "<TR>\n";
			echo "<TD >$Clave</TD>";
            echo "<TD >$elemento</TD>/n";
            echo "</TR>\n";
	}
      echo "</TABLE>\n";

}

//----------------------------------------------------------------------------------------------------------
function listar_matriz_asociada2($mimatriz, $micabecera)
//----------------------------------------------------------------------------------------------------------
// Lista matriz Asociada
{
	print "<table align=\"center\" border=\"0\" id=\"data\" cellspacing=\"2\" cellpadding=\"1\">";
    print "<tr>\n";
    foreach($micabecera as $hc)
	{
		print "<td class=\"cielo\"><font class=\"negro\">".$hc."</font></td>\n";
	}
    print "</tr>\n";
    print "<tr>\n";
    $listc=false;

	// Recorro los elementos de la matriz asociada
	while ($elemento = each($mimatriz))
	{
        if ($listc) $estilo="blanco"; else $estilo="gris";
		print "<td nowrap class=\"".$estilo."\"><font class=\"negro\">"."$elemento[key]"."</font></td>\n";
		print "<td nowrap class=\"".$estilo."\"><font class=\"negro\">"."$elemento[value]"."</font></td>\n";
		$listc =!$listc;
		print "</tr>\n";
	}
	print "</table>\n";
}


/**********************************************************************
*  PHP Perfect SQL v1.0						by Jose Carlos Garc�a Neila
* ----------------------------------------------------------------------
*  Realiza consultas SQL sin preocuparte de su sintaxis
*	
*  Modifique el c�digo a su gusto si lo desea y distribuyalo sin problema
*  ninguno, aunque si le pedir�a que incluya intacto este encabezado.
* 
*  http://www.distintiva.com/jose/_perf_sql
************************************************************************/



//------ Funciones de abstraccion de consultas SQL ---------------------


//----------------------------------------------------------------------------------------------------------
function get_insert($table, $columns, $values)
//----------------------------------------------------------------------------------------------------------
//-INSERT- $columns=get_commas(...)   $values=get_commas(...)
{
	return "INSERT INTO $table ($columns) VALUES ($values)";
}

//----------------------------------------------------------------------------------------------------------
function get_update($table, $values, $where)
//----------------------------------------------------------------------------------------------------------
//-UPDATE- $values=get_mult_set(...)   $where=get_mult_set(...) o get_simp_set(...)
{
	return "UPDATE $table SET $values WHERE $where";
}

//----------------------------------------------------------------------------------------------------------
function get_update_join($table_a, $table_b, $id_a, $id_b, $values, $where='')
//----------------------------------------------------------------------------------------------------------
//-UPDATE- actualiza una tabla con valores de otra (s�lo MySQL >4.xx)
{
	if($where!='')	$where="AND ($where)";
	return "UPDATE $table_a a, $table_b b SET $values WHERE a.$id_a=b.$id_b $where";
}

//----------------------------------------------------------------------------------------------------------
function get_select($table, $columns, $where='', $order='')
//----------------------------------------------------------------------------------------------------------
//-SELECT- $columns=get_commas(...) o '*'   $where=get_mult_set(...) o get_simp_set(...)
{
	$tmp = "SELECT $columns FROM $table";
	if($where!=''){
		$tmp.=" WHERE $where";
	}
	if($order!=''){
		$tmp.=" ORDER BY $where";
	}
	return $tmp;
}

//----------------------------------------------------------------------------------------------------------
function get_select_join($table_a, $table_b, $id_a, $id_b, $columns, $where='', $order='')
//----------------------------------------------------------------------------------------------------------
//-SELECT- entre 2 tablas por 2 indices comunes
{
	$table ="$table_a a, $table_b b";
	$w="a.$id_a=b.$id_b ";
	if($where!='')	$w.="AND ($where)";
	return get_select($table, $columns, $w, $order);
}

//----------------------------------------------------------------------------------------------------------
function get_delete($table, $where='')
//----------------------------------------------------------------------------------------------------------
//-DELETE-  $where=get_mult_set(...) o get_simp_set(...)
{
	$tmp = "DELETE FROM $table";
	if($where!='')
	{
		$tmp.=" WHERE $where";
	}
	return $tmp;
}
//----------------------------------------------------------------------------------------------------------
function get_commas()
//----------------------------------------------------------------------------------------------------------
//- get_commas(true|false, 1, 2, 4...) true pone comillas  => '1','2','4'...

{
	$a=func_get_args();
	$com = $a[0];
	return get_commasA(array_slice($a, 1, count($a)-1), $com);
}
//----------------------------------------------------------------------------------------------------------
function get_commasA($arr_in, $comillas=true)
//----------------------------------------------------------------------------------------------------------
{
	$temp='';
	$coma="'";
	if(!$comillas) $coma=''; //-el 1er param==true, metemos comas

	foreach($arr_in as $arg)
	{
	   if($temp!='')  $temp.=","; 
	   if(substr($arg,0,2)=='!!')
	  { //- Si empieza por !! no le pongo comas...
			$temp.=substr($arg,2); continue;
	   }
	   $temp.="$coma".$arg."$coma";
	}
	return $temp;
}

//----------------------------------------------------------------------------------------------------------
function get_simp_set($col, $val, $sign='=', $comillas=true)
//----------------------------------------------------------------------------------------------------------
//- Devuelve una asignacion (por defecto) simple entre comillas  X='1' 
{
	$cm="'";
	if(!$comillas) $cm='';
	if(substr($val,0,2)=='!!')
	{ //- Si empieza por !! no le pongo comas...
		$val=substr($val,2); $cm='';
	}
	return $col."$sign $cm".$val."$cm";
}

//-Mezcla cada valor de $a_cols, con uno de $a_vals   "X='1', T='2'...
//- ej:  con $simb='or'  X='1' or T='2'...
//- ej:  con $sign='>'   X>'1' or T>'2'...
//----------------------------------------------------------------------------------------------------------
function get_mult_set($a_cols, $a_vals, $simb=',', $sign='=', $comillas=true)
//----------------------------------------------------------------------------------------------------------
{
	$temp='';
	for($x=0;$x<count($a_cols);$x++)
	{
		if($temp!='')  $temp.=" $simb ";
	   $temp.= get_simp_set($a_cols[$x],$a_vals[$x], $sign, $comillas);
	}
	return $temp;
}
//----------------------------------------------------------------------------------------------------------
function get_between($col, $min, $max)
//----------------------------------------------------------------------------------------------------------
{
	return "($col BETWEEN $min AND $max)";
}


//----------------------------------------------------------------------------------------------------------
function SumaDatElem($matriz, $column1,$column2)
//----------------------------------------------------------------------------------------------------------
// Suma el contenido de las filas de  Columna 2 para  valores iguales
// y continuos de la  columna1
{	
	$filas	=count($matriz);
	$suma= 0;
	$item = $matriz[0][0];
	$j =0;
	if ($column1==$column2)	
	{
		$mresult[0][0]=Total($matriz,$column2);
	}
	else
	{
		for($i = 0; $i < $filas; $i++)
		{

			if($item == $matriz[$i][$column1] )
			{
					$suma=$suma+$matriz[$i][$column2];
			}
			else
			{
			
				for($k = 0; $k < $column2 ; $k++)
				{
					$mresult[$j][$k] = $matriz[$i-1][$k];
				}
				$mresult[$j][$column2] = $suma;
				$j= $j+1;

				$item = $matriz[$i][$column1];
				$suma = 0;
				$suma = $suma+$matriz[$i][$column2];

			}
			
		}
		for($k = 0; $k < $column2 ; $k++)
		{
			$mresult[$j][$k] = $matriz[$i-1][$k];
		}

		$mresult[$j][$column2] = $suma;
	}
	return $mresult;
}
