<?php
	/*mysql_connect("localhost","root","") or die ('error al conectarse');
	mysql_select_bd("agenda");*/
	$con = new mysqli('127.0.0.1','root','','agenda');
    $sql= "SHOW DATABASES";
    $res=$con->query($sql);
	?>