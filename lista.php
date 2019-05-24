<!DOCTYPE html>
<html>
	<title>Alterado</title>
	<head>
		<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
		<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" >
			$(document).ready(function() {
				var dataTable = $('#lista').DataTable( {
					"processing": true,
					"serverSide": true,
					"ajax":{
						url :"grid.php", // json datasource
						type: "post",  // method  , by default get
						error: function(){  // error handling
							$(".lista-error").html("");
							$("#lista").append('<tbody class="lista-error"><tr><th colspan="3"></th></tr></tbody>');
							$("#lista_processing").css("display","none");
							
						}
					}
				} );
			} );
		</script>
	</head>
	<body>
		<center> <h1>Exemplo 1</h1> </center>
		<div class="table-responsive">
			<table id="lista"  class="display table" width="100%">
				<thead> 
				        <tr><th> Codigo RN</th>
				        <th>Nome Recem Nascido</th>
				        <th> Dt.Nascimento</th>
				        <th>DNV </th>
				        <th>Naturalidade</th>
				        <th>Dt Cad.</th>
				        <th>Ação</th>
				        <th>Situação</th></tr>
				</thead>
			</table>
		</div>
	</body>
</html>