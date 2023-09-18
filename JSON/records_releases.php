<?php
header('Content-Type: application/json; charset=utf-8');
$app_key = '1742976590355';
$app_secret = 'df51a6bbb9a5ee49bf9dafd2365ab707';


$date_of = isset($_POST['dataDe']) ? date("d/m/Y", strtotime($_POST['dataDe'])) : date("d/m/Y");
$date_until = isset($_POST['dataAte']) ? date("d/m/Y", strtotime($_POST['dataAte'])) : date('d/m/Y');
$supplier_id = isset($_POST['supplier_ID']) ? $_POST['supplier_ID'] : null;
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
            "filtrar_apenas_inclusao" => "S",
            "filtrar_por_data_de" => $date_of,
            "filtrar_por_data_ate" => $date_until,
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


if (isset($json['faultstring'])) {
    $response = array(
        'faultstring' => $json['faultstring']
    );
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}else{
    $data = array();

    foreach ($json['conta_pagar_cadastro'] as $record) {
        $supID = $record['codigo_cliente_fornecedor'];
        $projID = isset($record['codigo_projeto']) ? $record['codigo_projeto'] : null;
        $supName = searchSupplier($supID);
        $projName = searchProject($projID);
        $Anexo = listAnexos($record['codigo_lancamento_omie']);
        if (isset($record['numero_documento_fiscal'])) {
            $numDoc = $record['numero_documento_fiscal'];
        }else {
            $numDoc = "";
        }

        $entry = array(
            'Data Inc.' => $record['data_entrada'],
            'id Omie' => $record['codigo_lancamento_omie'],
            'Nome Fornecedor' => $supName,
            'Id Bitrix' => $projName,
            'Codigo Cliente' => $record['codigo_cliente_fornecedor'],
            'Data Vencimento' => $record['data_vencimento'],
            'Data Previsao' => $record['data_previsao'],
            'Id Projeto' => @$record['codigo_projeto'],
            'ndoc' => $numDoc,
            'status' => $record['status_titulo'],
            'valor total' => $record['valor_documento'],

        );
        foreach ($record['categorias'] as $category) {
            $category_entry = array(
                'categoria' => $category['codigo_categoria'],
                'cat_valor' => $category['valor']
            );

            $entry['categorias'][] = $category_entry; // Adicionamos a categoria ao array 'categorias'
        }

        
        foreach ($Anexo as $cAnexos) {
            if (isset($cAnexos)) {
                $entry['anexos'][] = $cAnexos;
            }else {
                $entry['anexos'][] = "Nenhum Anexo";
            }
        }

        $data[] = $entry; // Adicionamos o lançamento ao array $data
    }

    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}

function searchSupplier($supplierID) {
    $app_key = '1742976590355';
    $app_secret = 'df51a6bbb9a5ee49bf9dafd2365ab707';

    $url = 'https://app.omie.com.br/api/v1/geral/clientes/';
    $params = array(
        'call' => 'ConsultarCliente',
        'app_key' => $app_key,
        'app_secret' => $app_secret,
        'param' => array(
            array(
                "codigo_cliente_omie" => $supplierID,
            )
        )
    );

    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignora a verificação do certificado SSL
    $response = curl_exec($ch);

    if (isset($response)) {
        $json = json_decode($response, true);
        curl_close($ch);
        $razao = isset($json['razao_social']) ? $json['razao_social'] : null;
        return $razao;
    }
    
}
function searchProject($projID) {
    $app_key = '1742976590355';
    $app_secret = 'df51a6bbb9a5ee49bf9dafd2365ab707';

    $url = 'https://app.omie.com.br/api/v1/geral/projetos/';
    $params = array(
        'call' => 'ConsultarProjeto',
        'app_key' => $app_key,
        'app_secret' => $app_secret,
        'param' => array(
            array(
                "codigo" => $projID,
            )
        )
    );

    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignora a verificação do certificado SSL
    $response = curl_exec($ch);

    if (isset($response)) {
        $json = json_decode($response, true);
        curl_close($ch);
        $project = isset($json['nome']) ? $json['nome'] : null;
        return $project;
    }
    
}

function listAnexos($idOmie) {
    $app_key = '1742976590355';
    $app_secret = 'df51a6bbb9a5ee49bf9dafd2365ab707';
  
    $url_cpagar = 'https://app.omie.com.br/api/v1/geral/anexo/';
    $params = array(
        'call' => 'ListarAnexo',
        'app_key' => $app_key,
        'app_secret' => $app_secret,
        'param' => array(
            array(
                "nId" => $idOmie,
                "cTabela" => "conta-pagar"
            )
        )
    );
    $ch = curl_init();
 
    // Configura as opções da requisição
    curl_setopt($ch, CURLOPT_URL, $url_cpagar);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignora a verificação do certificado SSL
    $response = curl_exec($ch);

    $json = json_decode($response, true);
    curl_close($ch);
    const data = JSON.parse(responseText);
    var toastContainer = document.querySelector('.toast-container');

    // Cria um elemento de toast
    var toast = document.createElement('div');
    toast.classList.add('toast');
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    var toastBody = document.createElement('div');
    toastBody.classList.add('toast-body');
    var list = document.createElement('ul');
    list.setAttribute('type' , 'circle');

    $anexo = array();
    foreach ($json['listaAnexos'] as $anexos) {
        if (!empty($anexos['cNomeArquivo'])) {
            $anexos_entry =  array(
                'cNomeArquivo' => $anexos['cNomeArquivo'],
                'nId' => $anexos['nId'],
                'nIdAnexo' => $anexos['nIdAnexo']
            );
            $anexo[] = $anexos_entry;
        }
    }
    
    for (var key in data) {
      if (data.hasOwnProperty(key)) {
        var listItem = document.createElement('li');
        listItem.textContent = data[key];
        list.appendChild(listItem);
      }
    }
    toastBody.appendChild(list);
    toast.appendChild(toastBody);
    toastContainer.appendChild(toast);

    var toastInstance = new bootstrap.Toast(toast);
    toastInstance.show();
    form.reset();

    
    return $anexo;

  }
  

?>

