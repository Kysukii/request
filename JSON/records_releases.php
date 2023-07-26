<?php
header('Content-Type: application/json; charset=utf-8');
$app_key = '1742976590355';
$app_secret = 'df51a6bbb9a5ee49bf9dafd2365ab707';


//$date_of = isset($_POST['dataDe']) ? date("d/m/Y", strtotime($_POST['dataDe'])) : date("d/m/Y");
//$date_until = isset($_POST['dataAte']) ? date("d/m/Y", strtotime($_POST['dataAte'])) : date('d/m/Y');
$supplier_id = isset($_POST['supplierID']) ? $_POST['supplierID'] : null;
$doc_status = isset($_POST['docStatus']) ? $_POST['docStatus'] : null;



    $url_cpagar = 'https://app.omie.com.br/api/v1/financas/contapagar/';
    $params = array(
        'call' => 'ListarContasPagar',
        'app_key' => $app_key,
        'app_secret' => $app_secret,
        'param' => array(
            array(
                "filtrar_apenas_titulos_em_aberto" => "",
                "apenas_importado_api" => "S",
                "ordem_descrescente" => "S",
                //"filtrar_por_data_de" => $date_of,
                //"filtrar_por_data_ate" => $date_until,
                "filtrar_cliente" => $supplier_id,
                "filtrar_por_status" => $doc_status
            )
        )
    );

    // Inicia a sessão cURL
    $ch = curl_init();

    // Configura as opções da requisição
    curl_setopt($ch, CURLOPT_URL, $url_cpagar);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignora a verificação do certificado SSL
    $response = curl_exec($ch);
    $json =  json_decode($response, true);

    //print_r($json);

    if (isset($json['faultstring'])) {
        $response = array(
            'faultstring' => $json['faultstring']
        );
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }else{
        $data = array(); // Criamos um array para guardar todos os registros

        foreach ($json['conta_pagar_cadastro'] as $record) {
            $entry = array(
                'Codigo Cliente' => $record['codigo_cliente_fornecedor'],
                'Data Vencimento' => $record['data_vencimento'],
                'Data Previsao' => $record['data_previsao'],
                'Id Projeto' => @$record['codigo_projeto'],
                'ndoc' => @$record['numero_documento_fiscal'],
                'status' => $record['status_titulo'],
                'valor total' => $record['valor_documento'],
                'categorias' => array() // Array vazio para armazenar as categorias do lançamento
            );
    
            foreach ($record['categorias'] as $category) {
                $category_entry = array(
                    'categoria' => $category['codigo_categoria'],
                    'cat_valor' => $category['valor']
                );
    
                $entry['categorias'][] = $category_entry; // Adicionamos a categoria ao array 'categorias'
            }
    
            $data[] = $entry; // Adicionamos o lançamento ao array $data
        }
    
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }




?>

