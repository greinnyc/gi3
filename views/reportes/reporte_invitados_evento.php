 <?php

$nombre_archivo = $name;
header("Content-Type:   application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=$nombre_archivo");  
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);

echo "<table border='0' width='200' cellPadding='0' cellSpacing='0'>";
echo "<tr><td>Fecha Generaci&oacute;n:</td> <td >".date('d/m/Y')."</td></tr>";
echo "</table>";





if(count($model) > 0){
	echo "<table class='FormTable' id='listado' width='100%' align='center' border='1' cellPadding='1' cellSpacing='0' >";
	echo "<tr style='background:FFFFFF'>";
	echo "<td align=center colspan=3><b>".utf8_decode("Invitados del evento.")."</td>";
	echo "</tr>";
	echo "<tr style='background:FFFFFF'>";
	echo "</tr>";
	echo "	<tr style='background:FFFFFF'>";
	echo "    	<td align=center><b>".utf8_decode("Número de documento")."</td>";
	echo "    	<td align=center><b>Nombre del invitado</td>";
	echo "    	<td align=center><b>".utf8_decode("Nombre del evento")."</td>";

	echo "	</tr>";


	foreach ($model as $row)
	    {
	        echo "	<tr style='background:FFFFFF'>"; 
	        echo "<td align=center><b>&nbsp;". $row['numero_documento']."</td>";
	        echo "<td align=center><b>&nbsp;". utf8_decode($row['nombre_invitado'])."</td>";
	        echo "<td align=center><b>&nbsp;". utf8_decode($row['nombre_evento'])."</td>";
	        echo "</tr>";
	    }
	echo "</table>";

}else{
	echo "<table class='FormTable' id='listado' width='100%' align='center' border='0' cellPadding='1' cellSpacing='0' >";
		echo "<tr style='background:FFFFFF'>";
		echo "<td align=left colspan=17>No se encontraron registros</td>";
		echo " </tr>";
		echo "</table>";
}

echo "</table>";


?>        