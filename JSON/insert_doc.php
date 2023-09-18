<?php
header('Content-Type: application/json; charset=utf-8');
$idOmie = $_POST['id_omie'];
$idSupplier = $_POST['docNumber'];
$expose = array();

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
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    $json =  json_decode($response, true);


    if (isset($json['faultstring'])) {
        $expose = array_merge($expose, array(
            'faultstring' => $json['faultstring']
        ));
    }else{
        $expose = array_merge($expose, array(
            'descricao_status' => $json['descricao_status']
        ));
        
        //INSERIR ANEXO!!!! ///        
        if(isset($_FILES['files']) && !empty($_FILES['files']['tmp_name'])) {
            if (!$_FILES['files']['error'][0]>0) {
    
              $caminhoTemporario = $_FILES['files']['tmp_name'][0];
              $nomeArquivo = $_FILES['files']['name'];
              $conteudoPDF = file_get_contents($caminhoTemporario);
              $arquivo = base64_encode($conteudoPDF);
              $md5Arq = md5($arquivo);
              $url_anexo = 'https://app.omie.com.br/api/v1/geral/anexo/';
    
              $zip = new ZipArchive;
              if ($zip->open($caminhoTemporario) === true) {
                for ($i = 0; $i < $zip->numFiles; $i++) {
                  $filename = $zip->getNameIndex($i);
                  // Define os parâmetros da solicitação
                  $params_anexo1 = array(
                    'call' => 'IncluirAnexo',
                    'app_key' => $app_key,
                    'app_secret' => $app_secret,
                    'param' => array(
                      array(
                          "cCodIntAnexo" => "",
                          "cTabela" => "conta-pagar",
                          "nId" => $idOmie,
                          "cNomeArquivo" => $filename,
                          "cTipoArquivo" => "",
                          "cArquivo" => $arquivo,
                          "cMd5" => $md5Arq
                      )
                    )
                  );
    
                // Inicia a sessão cURL
                  $ch = curl_init();
    
                  // Configura as opções da requisição
                  curl_setopt($ch, CURLOPT_URL, $url_anexo);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
                  curl_setopt($ch, CURLOPT_POST, true);
                  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params_anexo1));
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignora a verificação do certificado SSL
    
                  // Executa a requisição e armazena a resposta
                  $response = curl_exec($ch);
                  $json =  json_decode($response, true);
    
                  // Verifica se ocorreu algum erro durante a requisição
                  if(curl_error($ch)) {
                    echo 'Erro na requisição cURL: ' . curl_error($ch);
                  }else {
                    // Exibe o retorno da API
                    if (isset($json['faultstring'])) {
                        $expose = array_merge($expose, array(
                            'faultAnexo' => $json['faultstring']
                        ));
                        
                    }else{
                      if (!$json['cCodStatus']) {
                        $expose[] = array(
                            'cNomeArquivo' => $json['cNomeArquivo'],
                            'cDesStatus' => $json['cDesStatus']
                        );
                      }else {
                        $expose = array_merge($expose, array(
                            'error' => $json['cDesStatus']
                        ));
                      }
    
                    }
                  }
                } // fechamento do for ($i = 0; $i < $zip->numFiles; $i++)
              }
            }else {
                $expose = array_merge($expose, array(
                    'error' => 'Nenhum arquivo encontrado.'
                ));
            }
        }else{
            $expose = array_merge($expose, array(
                'error' => 'Nenhum anexo enviado.'
            ));
        }
        
        
    }
    echo json_encode($expose, JSON_UNESCAPED_UNICODE);

    



?>