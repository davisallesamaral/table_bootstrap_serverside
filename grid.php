<?php
$servername = "mysql.qlix.com.br";
$username = "5348_teste";
$password = "flkq0108";
$dbname = "5348_teste";

/* conectando a base de dados */
$conn = mysqli_connect($servername, $username, $password, $dbname);
$requestData= $_REQUEST; 
$columns = array( 
                 0 => 'p.codigo_paciente',
                  1=> 'p.nome_paciente',
                  2=>'p.dnv_paciente',
                  3=>'p.dnv_paciente',
                  4=>'p.naturalidade_paciente',
                  5=>'p.data_cadastro',
                  6=>'p.id_paciente',
                  7=>'p.status',
                  8=>'m.descricao_municipio');

$sql = "select        p.codigo_paciente,
                                p.nome_paciente,
                                p.data_nascimento,
                                 p.dnv_paciente,
                                p.naturalidade_paciente,
                                p.data_cadastro,
                                p.id_paciente,
                                p.status,
                                m.descricao_municipio
                                from tb_pacientes p, tb_municipios m
                            where  p.naturalidade_paciente = m.codigo_municipio    ";
$query	      = mysqli_query($conn, $sql);
$recordsTotal = mysqli_num_rows($query);
 
 
 //echo " total registros   >>".$recordsTotal ;
 /*
  * fazer pesquisa por campos da tabela
  */

if( !empty($requestData['search']['value']) ) {
 $sql.=" AND ( p.nome_paciente LIKE '".$requestData['search']['value']."%' ";
 $sql.=" OR p.data_nascimento LIKE '".$requestData['search']['value']."%' ";
 $sql.=" OR p.dnv_paciente LIKE '".$requestData['search']['value']."%' ";
 $sql.=" OR p.naturalidade_paciente LIKE '".$requestData['search']['value']."%' ";
 $sql.=" OR p.data_cadastro LIKE '".$requestData['search']['value']."%' ";
 $sql.=" OR p.id_paciente LIKE '".$requestData['search']['value']."%' ";
 $sql.=" OR p.status LIKE '".$requestData['search']['value']."%' ";
 $sql.=" OR m.descricao_municipioLIKE '".$requestData['search']['value']."%' ";
 
}
$query=mysqli_query($conn, $sql);
$recordsFiltered = mysqli_num_rows($query); 
/*
* Ordernar pela coluna escolhida
*/
$sql.= "  ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
/*
* Paginação
*/
//Vamos agora tratar da páginação:
$incrow = ($requestData['start']+1);
$fimrow = ($requestData['start']+ $requestData['length']);
$sql.= "  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
 /*
  * carregando  o array para exibição
  */

$data = array();
while( $row=mysqli_fetch_array($query) ) {  
	$nestedData=array(); 
                    $nestedData[] = $row['p.codigo_paciente'];
                    $nestedData[] = $row['p.nome_paciente'];
                    $nestedData[] = $row['p.data_nascimento'];
                    $nestedData[] = $row['p.dnv_paciente'];
                    $nestedData[] = $row['p.naturalidade_paciente'];
                    $nestedData[] = $row['p.data_cadastro'];
                    $nestedData[] = $row['p.id_paciente'];
                    $nestedData[] = $row['p.status'];
                    $nestedData[] = $row['m.descricao_municipio'];
                    $data[] = $nestedData;
}

 /*
  * Vamos montar o array que irá servir como base para montar o JSON:
  */

$json_data = array(
                                      "draw" => intval( $requestData["draw"] ),
                                       "recordsTotal" => intval( $recordsTotal ),
                                       "recordsFiltered" => intval( $recordsFiltered ),
                                       "data" => $data
     );
 echo json_encode($json_data);
?>