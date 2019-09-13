<?php     include 'conexion.php';  ?>   
<?php     include 'registro.php';   ?>   
<!DOCTYPE HTML PUBLIC "-//W3C//dtd html 4.0 Transitional //EN">
<HTML>
<HEAD>
<TITLE> Agenda </TITLE>
<link href="style.css" rel="stylesheet" type="text/css">

<?php 
echo "<span class=bienvenido> Bienvenido $_SESSION [nombre]! <a class=bienvenido href=registro.php?modo=terminarSesion> [Terminar Sesion]
</a></span><br><br>";
$con = new mysqli('127.0.0.1','root','','agenda');
$sql='select *';
$sql .='from detalle, nivel_importancia';
$sql .='where detalle.cod_nivel=nivel_importancia.cod_nivel';
$sql .=' and idusuario = '.$_SESSION [autorizado];

$res = $con ->query($sql);

if(mysql_num_rows($res))   {
    while ($row =fetch_array($res)) {
    $temp = explode (" ",  $row [fecha_inicio]) ;
    $temp1 = explode ("-",  $temp [0]) ;
    $temp1 = explode (":",  $temp [1]) ;
    $di = $temp1 [2];
    $ii = $temp1 [1];
    $ai = $temp1 [0];
    $hd = $temp2 [0];
    $md = $temp2[1];

    $inicio = mktime ($hd, $md, 0, $ii, $di, $ai);

    $temp = explode ("",  $row [fecha_fin]) ;
    $temp1 = explode ("-",  $temp [0]) ;
    $temp1 = explode (":",  $temp [1]) ;
    $di = $temp1 [2];
    $ii = $temp1 [1];
    $ai = $temp1 [0];
    $hd = $temp2 [0];
    $md = $temp2[1];
    $fin = mktime ($hd, $md, 0, $ii, $di, $ai);

    $ocupado [$row [cod_detalle]] = $inicio.' '.$fin.' '.$row[color];

}
if ($_GET[fecha]) {

    $fecha = explode ("-", $_GET[fecha]);
    $d =$fecha[2];
    $m =$fecha[1];
    $a =$fecha [0];
    $primer_dia = date ("w", mktime (0, 0, 0, $m, $d, $a)) +1;

    $array_dia[1] ='Domingo';
    $array_dia[] ='Lunes';
    $array_dia[] ='Martes';
    $array_dia[] ='Miercoles';
    $array_dia[] ='Jueves';
    $array_dia[] ='Vernes';
    $array_dia[] ='Sabado';

    echo '<table align="center border=1 cellspacing=0 cellpadding=0 bordercolor#84CA84>';

    for ($f=0; $f<=48; $f++)  {
        echo '<tr>';
        for ($c=0; $c<=7; $c++) {
            if ($c==0) {
                if ($f==0)
                echo '<td class=texto align=center valign=middle width=100>&nbdp;</td>';
                else {
                    $hora = str_pad($hora, 2, '0', STR_PAD_LEFT);

                    if ($f%2) {
                        $horaMinuto = $hora.' :00 hs.';

                    }  else {
                        $horaMinuto = $hora.' :30 hs.';
                        $hora++;
                    }

                    echo '<td class=horario align= center valing=middle width=100>' .$horaMinuto.' </td>';

                }
            } else {
                if ($f==0) {
                    if ($primer_dia==$c) {
                        $empieza_semana_titulo = 1;
                        echo '<td class=titulo align=center valign=middle width=140>' .$array_dia [$c].' '.$d.' </td>'; 
                    }
                    elseif ($empieza_semana_titulo) {
                        if (checkdate($m, ++$d, $a)) {
                            $d = str_pad ($d, 2, '0', STR_PAD_LEFT);
                            echo '<td class=titulo align=center valign=middle width=140>' .$array_dia [$c].' '.$d.' </td>';

                        }  else {
                            $mesSiguiente =1;
                            echo '<td class=texto align=center valign=middle width=140>' .$array_dia [$c].' '.$d.' </td>';
                        }
                    } else {
                        echo '<td class=texto align=center valign=middle width=140>' .$array_dia [$c].' '.$d.' </td>';
                        $mesAnterior++;
                    }
                
                } else {
                    if ($c==1) {
                        $h = $tempHora;

                        if ($f%2)
                        $i= '00';
                        else {
                            $i= '30';
                            $tempHora++;
                        }
                    }

                    if (($c <= $mesAnterior) or ($mesSiguiente)) 
                    echo "<td width=120>&nbsp; </td>";
                    else                 {

                        if ($primer_dia==$c) {
                            $empieza_semana =1;
                            $d=$fecha[2];
                        } elseif ($empieza_semana) {
                            $dd++;
                        }

                        echo okupado (mktime ($h, $i, 0, $m, $d, $a), $ocupado);
                    }

                }
            }
        }
        echo '</tr>';
    }
       echo '</table>';

}

function okupado ($timestamp, $ocupado) {
    if (!$ocupado)
      return "<td  width=120>&nbsp;</td>";
       foreach($ocupado as $clave => $valor)  {
           $temp = explode (" ", $valor);
            if ($timestamp >= $temp [0] and $timestamp < $temp [1])   {
                $fecha = date ("Y-m-d", $temp[0]) ;
                   return "<td bgcolor=$temp [2] onclick='javascript:window.location=\"abm.php?idcita=$clave&fecha=$fecha\";'
                   width=20 style=\"cursor:pointer\">$nbsp;</td>";
            }
       }
       return "<td width=120>&nbsp;</td>";
}

?>
<br><center><a href="index.php"> Ir al inicio </a> </center>

</BODY>
</HTML>