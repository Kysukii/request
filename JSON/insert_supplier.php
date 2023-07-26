<?php
header('Content-Type: application/json; charset=utf-8');
$app_key = '1742976590355';
$app_secret = 'df51a6bbb9a5ee49bf9dafd2365ab707';


    @$codInt = uniqid('', true);
    @$email = $_POST['email'];  
    @$rsocial = $_POST['razao_social'];
    @$nfantasia = $_POST['nome_fantasia'];
    @$cnpjcpf = $_POST['cnpj_cpf'];

    $url_cpagar = 'https://app.omie.com.br/api/v1/geral/clientes/';

    $params = array(
        'call' => 'IncluirCliente',
        'app_key' => $app_key,
        'app_secret' => $app_secret,
        'param' => array(
            array(
              "codigo_cliente_integracao" => $codInt,
              "email" => $email,
              "razao_social" => $rsocial,
              "nome_fantasia" => $nfantasia,
              "cnpj_cpf" => $cnpjcpf,
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


    if (isset($json['faultstring']) || isset($json['status']) == 'error') {
        $response = array(
            'faultstring' => $json['faultstring']
        );
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }else{
        if (!$json['cCodStatus']) {
            $response = array(
                $json['cNomeArquivo'] => $json['cDesStatus']
            );
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        }
    }





?>

