<?php     include 'conexion.php';          ?>
<?php     include 'registro.php';          ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>Agenda</TITLE>
<link href="style.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY>

<?php
echo "<span class=bienvenido>Bienvenido  $_SESSION[nombre]! <a class=bienvenido href=registro.php?modo=terminarSesion>[Terminar Sesion]</a></span><br><br>";

if ($_POST[NC])    {
	
$res = mysql_query('select max(cod_detalle) m from detalle');
if(mysql_num_rows($res)>0){
	$row = mysql_fetch_array($res);
	$max = $row[m] +1;


}else

$max = 1;

$fechaInicio = explode("-",$_POST[txtFechaInicio]);
$fechaInicio = $fechaInicio[2].'-'.$fechaInicio[1].'-'.$fechaInicio[0];

$horaInicio = explode(":", $_POST[txtHoraInicio]);
$horaInicio = $horaInicio[0].':'.$horaInicio[1].':00';

$inicio = "$fechaInicio $horaInicio";

$fechaFin = explode("-",$_POST[txtfechaFin]);
$fechaFin = $fechaFin[2].'-'.fechaFin[1].'-'.$fechaFin[0];

$horaFin = explode(":", $_POST[txtHoraFin]);
$horaFin = = $horaFin[0].':'.$horaFin[1].':00';

$fin = "$fechaFin $horaFin";

if (!$_POST[r_nivel])
	$_POST[r_nivel] = 2;

	$sql = "insert into detalle (cod_detalle, fecha_inicio, fecha_fin, descripcion, titulo, cod_nivel, idusuario,) values (".$max.",'".$inicio."', '".$fin."', '".$POST[taContenido]."', '".$POST[taTitulo]."',".$_POST¨[r_nivel].",".$_SESSION[autorizado].")";

	$res = mysql_query($sql);
	header("location : index.php?fecha=$fechaInicio"); 

}

 if ($_POST[GC])    {

 	$fechaInicio = explode("-", $_POST[txtFechaInicio]);
 	$fechaInicio = $fechaInicio[2].'-'.$fechaInicio[1].'-'.$fechaInicio[0];
 	$horaInicio = explode(":", $_POST[txtHoraInicio]);
 	$horaInicio = $horaInicio[0].':'.$horaInicio[1].':00';
 	$inicio = "$fechaInicio $horaInicio";
 	$fechaFin = explode("-", $_POST[txtFechaFin]);
 	$fechaFin = $fechaFin[2].'-'.$fechaFin[1].'-'.$fechaFin[0];

 	$horaFin = explode(":", $_POST[txtHoraFin]);
 	$horaFin = $horaFin[0].':'.$horaFin[1].':00';

 	$fin = "$fechaFin $horaFin";

 	$sql =  "update detalle set ";
 	$sql .= "fecha_inicio = '".$inicio."'";
 	$sql .= " , fecha_fin = '".$fin."'"; 
 	$sql .= " , descripcion = '".$_POST[taContenido]."'"; 
 	$sql .= " , titulo = '".$_POST[taTitulo]."'"; 
 	$sql .= " , cod_nivel = ".$_POST[r_nivel].; 
 	$sql .= " where cod_detalle = ".$_POST[cod_detalle].; 

 	$res = mysql_query($sql);

 	header ("location: index.php?fecha=$fechaInicio");
 }

  if ($_GET[fecha])            {
  	echo '<form method="post" action="">';
  	echo '<table aling="center" border=1 cellspacing=1 cellpadding=0
  			bordercolor="#84CA84" width="90%">';


  $fechaInicio = explode("-", $_GET[fecha]);
  $d       = $fecha[2];
  $m       = $fecha[1];
  $a       = $fecha[0];

  $sql = "select * from detalle where day (fecha_inicio) =$d and  month(fecha_inicio)=$m and year(fecha_inicio)=$a and idusuario = $SESSION[autorizado] order by fecha_inicio asc";

  $res = query($sql);

  if (mysql_num_rows($res)>0)

  $select = "<select onChange=\"if (this.value != 0)
  {javascript:window.location = 'abm.php?fecha=
  $_GET[fecha]&idcita='+this.value; }\">";
  $select .= '<option value=0>-------------------------------------<\option>';
  while ($row = fetch_array($res))     {
  	if($_GET[idcita]==$row[cod_detalle])   $modo = 'selected';
  	else                                      $modo =	'';
  	$select .= '<option '.$modo.' value='.$row[cod_detalle].
  		'>'.$row[titulo].'</option>';
  	}
select .= '</select>';

echo '<tr>';
echo '<td colspan=2>';

echo '      <table border=0 cellspacing=0 cellpadding=0
				width="100%"';

echo '        <tr>';
echo '    <td width=90% class="titulo" height="50">&nbsp;Citas disponibles en esta fecha: '.$select.'</td>';
echo '     <td bgcolor="#84CA84" class="titulo" height="50"
			align="center"><a href="abm.php?fecha=' .$_GET[fecha].'">Nueva Cita</a></td>';				
echo '			</tr>';
echo '          </table>';

echo '</td>';
echo '</tr>';
}else{
	echo '<tr>';
	echo '<td colspan=2>';

	echo   '     <table border=0 cellspacing=0 cellpadding=0
					width="100%">';
	echo '        <tr>';
	echo '		<td colspan=2 width=90% class="titutlo"
					height="50">&nbsp;No hay citas disponibles en esta fecha</td>';
					echo '      </tr>';
					echo '      </table>';
					echo '</td>';
					echo '</tr>';
	}
	if ($_GET[idcita])

			$sql= "select * from detalle where cod_detalle = $_GET[idcita] and idusuario = &_SESSION[autorizado]";
			$res = query($sql);

			if (!mysql_num_rows($res))
			echo ' <script language=javascript>';
			echo 'window.location = \'index.php\';';
			echo '</script>';

	}
	
$row = fetch_array($res);

echo '<tr>';
echo '<td class="titulo" colspan="2" height="30"
		align="center"> Datos de la cita:</td>';
		echo '</tr>';

}else{

echo '<tr>';
echo '<td class="titulo" colspan="2" height="30"
		align="center"> Datos de la nueva cita:</td>';
		echo '</tr>';

}
echo '<tr>';
echo '<td class="texto">&nbsp;Titulo</td>';
echo '<td class="texto">&nbsp;<textarea name=taTitulo rows=3 cols=40>'.$row[titulo].'</textarea></td>';
echo '</tr>';

echo '<tr>';
echo '<td class="texto">&nbsp;Cotenido</td>';
echo '<td class="texto">&nbsp;<textarea name=taContenido rows=4 cols=40>'.$row[descripcion].'</textarea></td>';
echo '</tr>';

echo '<tr>';
echo '<td class="texto">&nbsp;Nivel de prioridad</td>';
echo '<td class="texto">';

$sql_nivel = "select * from  mivel_importancia order by  desc_nivel asc ";
$res_nivel = query($sql_nivel);
while ($row_nivel = fetch_array($res_nivel))   {
	if($row_nivel[cod_nivel] == $row[cod_nivel])
		$checked = 'checked';
	echo '<input type=radio name=r_nivel value='.$row_nivel[cod_nivel].'
	'.$checked.'>&nbsp;&nbsp;'.$row_nivel[desc_nivel].'<br>';

}

echo '</td>';
echo '</tr>';

if ($_GET[idcita])   {
	$temp = explode(" ", $row[fecha_inicio]);
	$fecha = explode("-", $temp[0]);
	$hora= explode(":", $temp[1]);
	$fecha_inicio = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
	$hora_inicio = $hora[0].':'.$hora[1];


	$temp = explode(" ", $row[fecha_fin]);
	$fecha = explode("-", $temp[0]);
	$hora= explode(":", $temp[1]);
	$fecha_fin = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
	$hora_fin = $hora[0].':'.$hora[1];
	
}else{
	$fecha_inicio = $fecha_fin = $d.'-'.$m.'-'.$a;
	$hora_inicio = $hora_fin = '';

}

echo '<tr>';
echo '       <td width=50% class="texto">&nbsp;Fecha Inicio [dd-mm-aaaa] :
			<input type="text" size=12 name="txtFechaInicio"
			value="'.$fecha_inicio.'" size="53"></td>';	


echo '       <td width=50% class="texto">&nbsp;Hora Inicio [hh:mm] :
			'.cargar_hora("txtHoraInicio", $hora_inicio).'</td>';
		echo '</tr>';
		echo '<tr>';


echo '       <td width=50% class="texto">&nbsp;Fecha Fin [dd-mm-aaaa] :
			<input type="text" size=12 name="txtFechaFin"
			value="'.$fecha_inicio.'" size="53"></td>';	


echo '       <td width=50% class="texto">&nbsp;Hora Finalizacion [hh:mm] :
			'.cargar_hora("txtHoraFin", $hora_fin).'</td>';
echo '</tr>';

if ($_GET[idcita])
	echo '<tr>';
	echo '<td class="texto" colspan="2" align="center">&nbsp;<input type="submit" name="EC" value= " ELIMINAR CITA ">&nbsp;&nbsp;<input type="submit" name="GC" value= "Guardar Cambios "></td>';

	echo '</tr>';
	echo '</table>';
	echo '<input type=hidden name=cod_detalle  value='.$row[cod_detalle].'>';
} else { 
	echo '<tr>';
	echo '<td colspan="2" align="center">&nbsp;<input type="submit" name="NC" value= " Agregar cita"></td>';
	  echo '</tr>';
	  echo '</table>';

	 }
	 echo '</form>';
	}
	fuction cargar_hora ($nombre_select, $seleccionar_hora=0) {
		$sell = '<select name=' .$nombre_select.'>';
		for ($c=0; $c<48; $c++) {
			if (strlen ($x) ==1)   $x = '0' .$x; 
			elseif (strlen ($x) ==0)   $x = '00';
			if ($c%2=0)
				$hora =$x.':00'
			else {
				$hora =$x ':30';
				$x++
			}
			if ($hora == $seleccionar_hora)
				$modo = 'selected';
			else 
				$modo = '';

			$sell .= '<option '.$modo.' value=' .$hora.'>'.$hora.'</option';
		}
		$sell .= '</select>';
		return $sell;
	}
	?> 
	<center> <a href= "index.php"> Ir al inicio </a> </center>
</BODY>
</HTML>
	




