<?php
header('Content-Type: application/json; charset=utf-8');
$app_key = '1742976590355';
$app_secret = 'df51a6bbb9a5ee49bf9dafd2365ab707';

if (isset($_POST['idOmieExc'])){
    $cOmie = $_POST['idOmieExc'];

    $codigoLancamento = $cOmie;
    $url_cpagar = 'https://app.omie.com.br/api/v1/financas/contapagar/';

    $params = array(
        'call' => 'ExcluirContaPagar',
        'app_key' => $app_key,
        'app_secret' => $app_secret,
        'param' => array(
            array(
                'codigo_lancamento_omie' => $codigoLancamento,
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

    // Verifica se a chamada cURL foi bem-sucedida
    if ($response === false) {
        echo json_encode(array('error' => 'Erro na chamada cURL: ' . curl_error($ch)), JSON_UNESCAPED_UNICODE);
    } else {
        // Decodifica a resposta JSON da API do Omie
        $decoded_response = json_decode($response);

        // Verifica se a decodificação foi bem-sucedida
        if ($decoded_response !== null) {
            echo json_encode($decoded_response, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(array('error' => 'Erro na decodificação JSON da resposta.'), JSON_UNESCAPED_UNICODE);
        }
    }

    // Fecha a sessão cURL
    curl_close($ch);
}
?>
