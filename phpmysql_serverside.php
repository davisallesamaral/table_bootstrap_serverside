<?php
/* Iniciando a conexão com o banco de dados */
$servername = "mysql.qlix.com.br";
$username   = "5348_teste";
$password   = "flkq0108";
$dbname     = "5348_teste";

/* conectando a base de dados */
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Armazenando o array (GET/POST) 
$requestData= $_REQUEST; 
// Essas informações vem do FRAMEWORK 
// Segue algumas variáveis que serão úteis no nosso exemplo e são passadas pelo ajax:
//order[0][column]:0 -  Diz qual é a coluna que você solicitou a ordenação (começa a partir do zero);
//order[0][dir]:desc -  Diz se a ordenação é asc ou desc, isso é crescente ou decrescente;
//start:0   - Informa a partir de qual registro será demonstrado o dado; 
//length:10 - Informa quantos registros serão demonstrados por vez na consulta; 
//search[value]: Informa os valores digitados no campo Search

//Agora vamos criar um array dos campos da tabela ou das tabelas que você quer pesquisar e demonstrar na tabela.
$columns = array( 
		 0=>'p.CODIGO_PACIENTE',
		 1=>'p.NOME_PACIENTE',
		 2=>'p.DATA_NASCIMENTO',
		 3=>'p.DNV_PACIENTE',
                 4=>'p.NATURALIDADE_PACIENTE',
                 5=>'p.DATA_CADASTRO',
                 6=>'p.ID_PACIENTE',
                 7=>'p.STATUS',
                 8=>'m.DESCRICAO_MUNICIPIO'
                 );

// Vamos então pegar o tatal de registro existente na consulta, sem nenhum tipo de filtro. 
// Esse total será demonstrado da seguinte forma: (filtered from 99,999 total entries)
$sql = "select p.CODIGO_PACIENTE,
               p.DATA_NASCIMENTO,
               p.DATA_NASCIMENTO,
               p.DNV_PACIENTE, p.NATURALIDADE_PACIENTE, p.DATA_CADASTRO, p.ID_PACIENTE, p.STATUS, m.DESCRICAO_MUNICIPIO
         from  tb_pacientes p, tb_municipios m
         where p.naturalidade_paciente = m.codigo_municipio ";
$query=mysqli_query($conn, $sql);
$recordsTotal = mysqli_num_rows($query);

//Para não fazer uma consulta em vão, vamos antes verificar se o campo search tem algum valor.
//Se houver um parâmetro de pesquisa, colocar os Likes
if( !empty($requestData['search']['value']) ) {   
	$sql.=" AND ( p.NOME_PACIENTE LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR m.DESCRICAO_MUNICIPIO LIKE '".$requestData['search']['value']."%' )";
}

//Agora vamos capturar a quantidade de registros achados a partir das informações vinda do search:

$query=mysqli_query($conn, $sql);
$recordsFiltered = mysqli_num_rows($query); 

//Exemplo Showing 1 to 10 of 502 entries (filtered from 97,132 total entries)
// 502 seria o resultado do "mysqli_num_rows($query);" passado para a variável $recordsFiltered;


$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  // adding length
$query=mysqli_query($conn, $sql);
 


//echo ($sql);

$query=mysqli_query($conn, $sql);

// Agora vamos executar o select que irá preencher os registros que irão aparecer na tabela: 
// preparando o array;
$data = array();
while( $row=mysqli_fetch_array($query) ) {  
	$nestedData=array(); 
	$nestedData[] = $row["CODIGO_PACIENTE"];
	$nestedData[] = $row["NOME_PACIENTE"];
	$nestedData[] = $row["DATA_NASCIMENTO"];
	$nestedData[] = $row["DNV_PACIENTE"];
	$nestedData[] = $row["NATURALIDE_PACIENTE"];
	$nestedData[] = $row["DATA_CADASTRO"];
	$nestedData[] = $row["ID_PACIENTE"];
	$nestedData[] = $row["STATUS"];	
	$nestedData[] = $row["DESCRICAO_MUNICIPIO"];	
	$data[] = $nestedData;
}
//Vamos montar o array que irá servir como base para montar o JSON
$json_data = array(	"draw"            => intval( $requestData['draw'] ),    
			"recordsTotal"    => intval( $recordsTotal ),  
			"recordsFiltered" => intval( $recordsFiltered ), 
			"data"            => $data   
			);

// json_encode — Retorna a representação JSON de um valor. Retorna a string contendo a representação JSON de um value.
echo json_encode($json_data);  
?>