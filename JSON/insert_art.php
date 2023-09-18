<?php
//header('Content-Type: application/json; charset=utf-8');

$supplier_name = isset($_POST['supplier_ID']) ? $_POST['supplier_ID'] : '';
$banks = isset($_POST['bank']) ? $_POST['bank'] : '';
$due_date = isset($_POST['due_date']) ? date('d/m/Y', strtotime($_POST['due_date'])) : '';
$project = isset($_POST['projects_ID']) ? $_POST['projects_ID'] : '';
$categorias = isset($_POST['categorie']) ? $_POST['categorie'] : '';
$valorCat = isset($_POST['valorCategoria']) ? str_replace(array('R$', ','), array('', '.'), $_POST['valorCategoria']) : '';
$ndoc = isset($_POST['ndoc']) ? $_POST['ndoc'] : '';

$expose = array();

// Verifica se todas as variáveis estão definidas e não são nulas
if ($supplier_name !== '' && $banks !== '' && $due_date !== '' && $project !== '' && $categorias !== '' && $valorCat !== '') {
  $app_key = '1742976590355';
  $app_secret = 'df51a6bbb9a5ee49bf9dafd2365ab707';
  
  // INSERIR CONTA A PAGAR
    $url_cpagar = 'https://app.omie.com.br/api/v1/financas/contapagar/';
    $url_listar_clientes = 'https://app.omie.com.br/api/v1/geral/clientes/';
    $uniqueid = uniqid('', true);
    // Define os parâmetros da solicitação
    $params = array(
        'call' => 'IncluirContaPagar',
        'app_key' => $app_key,
        'app_secret' => $app_secret,
        'param' => array(
            array(
                'codigo_lancamento_integracao' => $uniqueid,
                'codigo_cliente_fornecedor' => $supplier_name,
                'data_vencimento' => $due_date,
                'valor_documento' => $valorCat,            
                'id_conta_corrente' => $banks,
                'categorias' => $categorias,
                'codigo_projeto' => $project,
                'numero_documento_fiscal' => $ndoc
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
    if(curl_error($ch)) {
      echo json_encode(curl_error($ch), JSON_UNESCAPED_UNICODE);
    }else{
        // Exibe o retorno da API
        if (isset($json['faultstring'])) {
          //header('Content-Type: application/json; charset=utf-8');
          $expose = array_merge($expose, array(
            'faultstring' => $json['faultstring']
          ));
        }else{
          $codomie = $json['codigo_lancamento_omie'];
          $expose = array_merge($expose, array(
            'Status' => $json['descricao_status']
          ));
          // INSERIR ANEXO AO LANCAMENTO
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
                          "nId" => $codomie,
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
                    if ($json['cCodStatus'] > 0) {
                      $expose = array_merge($expose, array(
                        'faultAnexo' => $json['cDesStatus']
                      ));
                      
                    }else{

                      $cNomeArquivo[] = $json['cNomeArquivo'];
                      $cDesStatus[] = $json['cDesStatus'];

                        // $expose = array(
                        //   'cNomeArquivo' => array($json['cNomeArquivo']),
                        //   'cDesStatus' => array($json['cDesStatus']),
                        // );
                        
                    }
                    //echo json_encode($expose, JSON_UNESCAPED_UNICODE);
                  }
                } // fechamento do for ($i = 0; $i < $zip->numFiles; $i++)
                $expose['cNomeArquivo'] = $cNomeArquivo;
                $expose['cDesStatus'] = $cDesStatus;
              }else {
                $expose = array_merge($expose, array(
                  'error' => 'Arquivo não foi lido corretamente.'
                ));
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
    }
} else {
  
    // Alguma(s) variável(eis) não possui(em) valor
    $expose = array(
      'faultstring' => 'Os campos obrigatórios não foram preenchidos corretamente.'
    );
    
    echo json_encode($expose, JSON_UNESCAPED_UNICODE);
}

echo json_encode($expose, JSON_UNESCAPED_UNICODE);

?>