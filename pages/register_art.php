
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
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
      <h1>Formulário - Enviar ART para Pagamento</h1>
      <br/>
      <div class="col-lg-8 px-0">
        <form id="register_art" action="../JSON/insert_art.php" method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-8 mb-3" hidden>
              <input class="form-control" id="supplierID" name="supplier_ID" value="1713390830">
              <input class="form-control" id="supplierID" name="bank" value="6359951444">
              <input class="form-control" id="supplierID" name="categorie" value="2.02.97">
              <input type="text" name="ndoc" class="form-control" id="nDoc" value="N/A">
            </div>
          </div>
            
          <div class="row">
            <div class="col-4 mb-3">
              <label for="dueDate" class="form-label">Data de Vencimento:</label>
              <input type="date" name="due_date" class="form-control" id="dueDate">
            </div>
            <div class="col-4 mb-3">
              <label for="projectName" class="form-label">Projeto:</label>
              <input name="projects_name" list="datalistProjects" class="form-control" id="projectName" placeholder="ID do BITRIX">
              <input name="projects_ID" class="form-control" id="projects_ID" hidden>
              <datalist id="datalistProjects">
              </datalist>
            </div>

            <div class="col-4 mb-3">
              <label for="catVal1" class="form-label">Valor:</label>
              <input type="text" id="catVal1" class="form-control catval" name="valorCategoria" placeholder="Valor monetário">
            </div>

          </div>

          <div class="row">      
            <div class="col-12 mb-2">
              <label for="files" class="form-label">Enviar Anexos:</label>
              <input id="files" class="form-control" type="file" name="files[]" multiple>
              
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
      <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container top-0 end-0 p-3">
          
        </div>
      </div>



    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="../main.js"></script>
  </body>
</html>


<script>

  // function chamaToast(text) {
  //   const toast = document.querySelector('.toast');
  //   var toastInstance = new bootstrap.Toast(toast);
  //   $('.toast-body').html(text);
  //   toastInstance.show();
  // }
  // impede o envio do formulario
  $(document).on('keydown', function(event) {
    if (event.key === 'Enter') {
      event.preventDefault();
    }
  });

 
//SEARCH PROJETO

  const projectInput = document.getElementById('projectName');
  projectInput.addEventListener('input', () => {
    searchProject();
  });
  function searchProject() {
    var form = document.getElementById("register_art"); // Obtenha o elemento do formulário pelo ID
    var formData = new FormData(form); // Crie um objeto FormData para enviar o formulário

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../JSON/search_project.php');
    xhr.onload = function() {
      if (xhr.status === 200) {
        const responseText = xhr.responseText.trim();
        if (responseText) {
          const data = JSON.parse(responseText);
          const projectlist = document.getElementById("datalistProjects");
          projectlist.innerHTML = ""; // Limpa as opções existentes
          
          for (const key in data) {
            const optionProject = document.createElement("option");
            optionProject.value = key;
            projectlist.appendChild(optionProject);
            const projID = $('#projects_ID').attr('value', data[key]);
          }

        } else {
          console.log(responseText);
        }
      }
    };
    xhr.send(formData); // Envie o objeto FormData como dados da solicitação
  }


// envia o formulario ao clicar no botao enviar
  $('#register_art').on('submit', function(event) {
    if (event.originalEvent.submitter && event.originalEvent.submitter.id === 'sendFormBtn') {
      event.preventDefault();
      $('#valorTotalParcela').removeAttr('disabled');
      $('#btnSendSpin').removeAttr("hidden");
      $('#sendFormBtn').attr('disabled', 'disabled');
      $('#btnSendName').html('Enviando');
      if ($('#dateIssue').val() === '') {
        $('#dateIssue').attr('disabled', 'disabled');
      }
      setTimeout(function() {
        returnART();
      }, 1500);
      
    } else {
     return false;
    }
  });

//AJAX para retornar JSON de pages/insert_payment
  function returnART() {
    const form = document.getElementById("register_art"); 
    const formData = new FormData(form); 

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../json/insert_art.php');
    xhr.onload = function() {
      if (xhr.status === 200) {
        const responseText = xhr.responseText.trim();
        if (responseText) {
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
          $('#btnSendSpin').attr('hidden', 'hidden');
          $('#sendFormBtn').removeAttr('disabled');
          $('#btnSendName').html('Enviar');
        } else {
          console.log('Erro no envio.');
        }
      }
    };
    xhr.send(formData);
  }

//JQUERY
  $(document).ready(function() {
  // mascara BRL
    $('.catval').mask('000.000.000.000.000,00', { reverse: true });
    
  // habilita ndoc quando contem conteudo em files[]
    $('#files').on('change', function() {
      var files = $(this).prop('files');
      var nDoc = $('#nDoc');
      var iDate = $('#dateIssue');

      if (files.length > 0) {
        nDoc.prop('disabled', false);
        iDate.prop('disabled', false);
      } else {
        nDoc.prop('disabled', true);
        iDate.prop('disabled', true);
      }
    });


  });

</script>
