<?php
	include ("/../../php/functions.php");

	$dia=$_GET["dia"];
	$hoy=_get_hoy();
	$exp=explode("-",$hoy);
	$mm=$exp[1];
	$yyyy=$exp[0];
	$thead="<table border='1' style='width:1300px; border-collapse:collapse'>
				<thead style='color:white'>
					<tr id='mmyyyy' bgcolor='#FF6600'>
						<th style='width:500px;'>Cliente</th>
						<th style='width:100px;'>Tasa</th>";
	$tbody="		</tr>
				</thead>
				<tbody id='contenido' style='background:black'>

				</tbody>
			</table>";
	$monthyear="";

	$n=(int)$mm+2; $year=(int)$yyyy-1; $id="";
	for($i=0; $i<12; $i++){
		if($n>=13){
			$n=1;
			$year=$year+1;
		}
		$month=$n;
		if($n<=9){
			$month="0".$n;
		}
		$id=$year."-".$month."-".$dia;
		$monthyear=_convert_date_lit($id);
		$thead=$thead."<th id='$id' style='width:80px'>$monthyear</th>";
		//$tbody=$tbody."<td id='$id'>Refrendos</td>";
		$n=$n+1;
	}
	echo $thead.$tbody;
?>