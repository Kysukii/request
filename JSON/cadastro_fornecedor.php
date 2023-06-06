<!DOCTYPE html>
<html>
<head>
  <title>Exemplo de Autocomplete com Materialize</title>
  <!-- Importar CSS do Materialize -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <!-- Importar jQuery -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <!-- Importar JavaScript do Materialize -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</head>
<body>
<?php
require_once('navbar.php');

?>


<div class="container">
  <div class="center">
    <h4>Cadastro Fornecedores</h4>
  </div><br/>

  <form id="cadastro_forn" name="cadastrar_fornecedor" action="inserir_fornecedor" method="POST">
      <div class="row">
        <div class="col s6">
          <input hidden id="codfornecedor" type="text" name="codigo_cliente_integracao" value=""/>
          <label for="razaosocial">Razao Social</label>
          <input id="razaosocial" type="text" name="razao_social" value=""/>
        </div>
        <div class="col s6">
          <label for="nomefantasia">Nome Fantasia</label>
          <input id="nomefantasia" type="text" name="nome_fantasia" value=""/>
        </div>
        <div class="col s6">
        <label for="cnpj_cpf">CPF/CNPJ: </label>
        <input id="cnpj_cpf" type="text" name="cnpj_cpf" value=""/>
        </div>
        <div class="col s6">
          <label for="email">Email:</label>
          <input id="email" type="email" name="email" value=""/>
        </div>
      </div>
      <div class="row">
        <input class="btn" type="submit" value="Enviar" name="sendForm"/>
      </div>
  </form>

  <span id="responseDataValue" style="display: none;"></span>

</div>

</body>



<script>

  $('#cadastro_forn').submit(function(event) {
    event.preventDefault();
    inserirFornecedor();
    //document.getElementById('cadastro_forn').reset();

  });


function inserirFornecedor() {
  var form = document.getElementById("cadastro_forn"); // Obtenha o elemento do formulário pelo ID
  var formData = new FormData(form); // Crie um objeto FormData para enviar o formulário

  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'inserir_fornecedor.php');
  xhr.onload = function() {
    if (xhr.status === 200) {
      const responseText = xhr.responseText.trim();
      if (responseText) {
        const data = JSON.parse(responseText);
        // var responseDataValue = document.getElementById("responseDataValue");
        // responseDataValue.textContent = JSON.stringify(data); // Converte o objeto em uma string
        if (data['faultstring']) {
          M.toast({html: data['faultstring']}); // Exibe o valor em um M.toast
        }else {
          M.toast({html: data['descricao_status']}); // Exibe o valor em um M.toast
        }
        
      } else {
        console.log(responseText);
          M.toast({html: 'Erro no envio.'})
      }
    }
  };
  xhr.send(formData); // Envie o objeto FormData como dados da solicitação
}
</script>
</html>


