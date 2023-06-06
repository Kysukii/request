<?php

$app_key = '1742976590355';
$app_secret = 'df51a6bbb9a5ee49bf9dafd2365ab707';


    $codInt = uniqid('', true);
    if (isset($_POST['projects_name'])) {
        $fornName = $_POST['projects_name'];  

        $url_cpagar = 'https://app.omie.com.br/api/v1/geral/projetos/';

        $params = array(
            'call' => 'ListarProjetos',
            'app_key' => $app_key,
            'app_secret' => $app_secret,
            'param' => array(
                array(
                    "pagina" => 1,
                    "registros_por_pagina" => 50,
                    "apenas_importado_api" => "N",
                    "nome_projeto" => $fornName
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
        curl_close($ch);

        
        $data = json_decode($response, true);
        if (!isset($data['faultstring'])) {
            $fornecedores = array();
            foreach ($data['cadastro'] as $cadastro) {    
                $fornecedores[$cadastro['nome']] = $cadastro['codigo'];  
            }
            header('Content-Type: application/json'); 
            print_r(json_encode($fornecedores));
        }else {
            $falt = json_encode($data['faultstring']);
            header('Content-Type: application/json'); 
            echo json_encode(['faultstring' => $falt]);
        }
        
    }
    

?>

