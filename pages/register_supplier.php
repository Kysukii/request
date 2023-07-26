
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Fornecedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

  </head>
  <?php
    include("../navbar.php");
  ?>


  </head>
  <body>

    <div class="container my-5">
      <h1>Registrar Fornecedor</h1>
      <br/>
      <div class="col-lg-8 px-0">
        <form id="register_supplier" action="../JSON/insert_supplier.php" method="POST">
          <div class="row">
            <div class="col-6 mb-3">
              <label for="razaosocial">Razao Social</label>
              <input class="form-control" id="razaosocial" type="text" name="razao_social" value=""/>
            </div>
            <div class="col-6 mb-3">
              <label for="nomefantasia">Nome Fantasia</label>
              <input class="form-control" id="nomefantasia" type="text" name="nome_fantasia" value=""/>
            </div>
          </div>
            
          <div class="row">
            <div class="col-6 mb-3">
              <label for="cnpj_cpf">CPF/CNPJ: </label>
              <input class="form-control" id="cnpj_cpf" type="text" name="cnpj_cpf" value=""/>
            </div>
            <div class="col-6 mb-3">
              <label for="email">Email:</label>
              <input class="form-control" id="email" type="email" name="email" value=""/>
            </div>
          </div>

          <hr class="col-12 my-4"> 

          <button id="sendFormBtn" class="btn btn-primary" type="submit" value="Enviar" name="sendFormBtn">
            <span id="btnSendSpin" class="spinner-border spinner-border-sm" hidden="hidden" role="status" aria-hidden="true"></span>
            <span id="btnSendName">Enviar</span>
          </button>

        </form>
      </div>
      
      <!-- toast -->
      <div class="toast position-fixed top-0 end-0 text-bg-primary border-0 fade" role="alert" aria-live="assertive" aria-atomic="true" STYLE="margin: 5em 4em;">
        <div class="d-flex">
          <div class="toast-body">
            
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="../main.js"></script>
  </body>
</html>


<script> //scripts jquery
  $('#register_supplier').submit(function(event) {
    event.preventDefault();

    $('#btnSendSpin').removeAttr("hidden");
    $('#sendFormBtn').attr('disabled', 'disabled');
    $('#btnSendName').html('Enviando');
    setTimeout(function() {
        insertSupplier();
    }, 1500);

    //document.getElementById('cadastro_forn').reset();
  });
</script>

<script> //scripts js
  function chamaToast(text) {
    const toast = document.querySelector('.toast');
    var toastInstance = new bootstrap.Toast(toast);
    $('.toast-body').html(text);
    toastInstance.show();
  }




  function insertSupplier() {
    var form = document.getElementById("register_supplier"); // Obtenha o elemento do formulário pelo ID
    var formData = new FormData(form); // Crie um objeto FormData para enviar o formulário

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../json/insert_supplier.php');
    xhr.onload = function() {
      if (xhr.status === 200) {
        const responseText = xhr.responseText.trim();
        if (responseText) {
          const data = JSON.parse(responseText);
          for (var key in data) {
            const chave = key;
            if (chave == 'faultstring') {
              chamaToast(data[key]);
            }else {
              chamaToast(data[key]);
              form.reset();
            }
          }
          $('#btnSendSpin').attr('hidden', 'hidden');
          $('#sendFormBtn').removeAttr('disabled');
          $('#btnSendName').html('Enviar');
        } else {
          console.log(responseText);
            M.toast({html: 'Erro no envio.'})
        }
      }
    };
    xhr.send(formData); // Envie o objeto FormData como dados da solicitação
  }
</script>