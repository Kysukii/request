<?php

@$idOmie = $_GET['idOmie'];
@$idSupplier = $_GET['docNumber'];

    $app_key = '1742976590355';
    $app_secret = 'df51a6bbb9a5ee49bf9dafd2365ab707';

    $url = 'https://app.omie.com.br/api/v1/financas/contapagar/';
    $params = array(
        'call' => 'AlterarContaPagar',
        'app_key' => $app_key,
        'app_secret' => $app_secret,
        'param' => array(
            array(
                "codigo_lancamento_omie" => $idOmie,
                "numero_documento_fiscal" => $idSupplier
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
    echo $response;


    



?>