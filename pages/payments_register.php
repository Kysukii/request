
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
      <h1>Formulário - Ordem de pagamento</h1>
      <br/>
      <div class="col-lg-8 px-0">
        <form id="register_payment" action="../JSON/insert_payments.php" method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-8 mb-3">
              <label for="supplierName" class="form-label">Fornecedor:</label>
              <input class="form-control" list="datalistSuppliers" id="supplierName" name="supplier_name" placeholder="Digite para Procurar...">
              <input class="form-control" id="supplierID" name="supplier_ID" hidden>
              <datalist id="datalistSuppliers">
              </datalist>
            </div>
            <div class="col-4 mb-3">
              <label for="banks" class="form-label">Banco:</label>
              <select name="banks" id="banks" name="banks" class="form-control">
                <option value="6359951444">Itaú Unibanco</option>
                <option value="1610278771">Sicoob</option>
                <option value="1723162924">Conta Simples</option>
                <option value="1713443450">MasterCard - Sicoob</option>
                <option value="6569852399">Itaú Card</option>
              </select>
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
            <div class="col-4 mb-3" style="text-align: center;">
              <label class="form-label">Adicionar Categorias:</label>
              <div class="row gap-2 d-flex justify-content-center">
                <button type="button" class="btn btn-primary col-4" id="btnAdicionarCategoria">ADD</button>
                <button type="button" class="btn btn-danger col-4" id="btnRemoverCategoria">DEL</button>
              </div>
            </div>
          </div>

          <div class="row">
            <div id="containerCategorias" >
              <div class="row">
                <div class="col-8 mb-3">
                  <label for="cat1" class="form-label">Categoria:</label>
                  <select class="form-control" name="categorias[]" placeholder="Categoria 1" id="cat1">
                    <option value="" disabled selected>Escolha uma categoria</option>
                    <optgroup label="Material Fotovoltaico">
                      <option value="2.01.01" class="Mercadoria para Renvenda (KIT/TRAFO)">Mercadoria para Renvenda (KIT/TRAFO)</option>
                      <option value="2.01.02" class=""> Frete e Armazenamento de KIT</option>
                    </optgroup>
                    <optgroup label="Custo de Instalação">
                      <option value="2.02.01" class="Mão de obra"> Mão de obra</option>
                      <option value="2.02.02" class="Material C.A"> Material C.A</option>
                      <option value="2.02.03" class="Material C.C"> Material C.C</option>
                      <option value="2.02.04" class="Custo Não Previsto"> Custo Não Previsto</option>
                      <option value="2.02.94" class="Manutenção de Sistemas"> Manutenção de Sistemas</option>
                    </optgroup>
                    <optgroup label="Custos Extras">
                      <option value="2.02.96" class="Placas de Aviso"> Placas de Aviso</option>
                      <option value="2.02.97" class="Projeto e ART"> Projeto e ART</option>
                      <option value="2.02.98" class="Visita Técnica"> Visita Técnica</option>
                      <option value="2.02.99" class="Frete e Logística de Insumos"> Frete e Logística de Insumos</option>
                      <option value="2.03.01" class="Reforma de Padrão" class=""> Reforma de Padrão</option>
                      <option value="2.03.02" class="Laudo Estrutural"> Laudo Estrutural</option>
                      <option value="2.03.03" class="Obra Civil"> Obra Civil</option>
                      <option value="2.03.04" class="Aterramento"> Aterramento</option>
                      <option value="2.03.05" class="Locação de Equipamentos"> Locação de Equipamentos</option>
                    </optgroup> 
                  </select> 
                </div>
                <div class="col-4 mb-3">
                  <label for="catVal1" class="form-label">Valor:</label>
                  <input type="text" id="catVal1" class="form-control catval" name="valorCategoria[]" placeholder="Valor monetário" onblur="calcularTotal()" oninput="calcularTotal()">
                </div>
              </div>
            </div>
          </div> 

          <div class="row">
            <div class="col-8 mb-2">
              <label for="solicitante" class="form-label">Solicitante:</label>
              <select class="form-control" name="requester" id="solicitante">
                <option>Carlos Magno</option>
              </select>
            </div>
            <div class="col-4 mb-2">
              <label for="valorTotalParcela" class="form-label">Valor Total:</label>
              <input type="text" name="TotalParcela" class="form-control" id="valorTotalParcela" disabled>
            </div>
          </div>

          <div class="row">      
            <div class="col-6 mb-2">
              <label for="files" class="form-label">Enviar Anexos:</label>
              <input id="files" class="form-control" type="file" name="files[]" multiple>
              
            </div>
            <div class="col-3 mb-2 ">
              <label for="nDoc" class="form-label">N. NF:</label>
              <input type="text" name="numNF" class="form-control" id="nDoc" placeholder="Num. Nota Fiscal" disabled>
            </div>
            <div class="col-3 mb-2">
              <label for="dateIssue" class="form-label">Data de Emissão:</label>
              <input type="date" name="issueDate" class="form-control" id="dateIssue" disabled>
            </div>
          </div>

          <div class="row">
            <div class="col-12 mb-2">
              <label class="form-label" for="floatingTextarea" style="margin-left: 5px;">Observação:</label>
              <textarea name="observation" class="form-control" placeholder="Digitar um Comentário" id="floatingTextarea"></textarea>
            </div>

          </div>
          
          <div id="containerParcelas">

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


<script>

  function chamaToast(text) {
    const toast = document.querySelector('.toast');
    var toastInstance = new bootstrap.Toast(toast);
    $('.toast-body').html(text);
    toastInstance.show();
  }

//SEARCH FORNECEDOR

  const supplierInput = document.getElementById('supplierName');
  supplierInput.addEventListener('input', () => {
    searchSupplier();
  });
  function searchSupplier() {
    var form = document.getElementById("register_payment"); // Obtenha o elemento do formulário pelo ID
    var formData = new FormData(form); // Crie um objeto FormData para enviar o formulário

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../JSON/search_supplier.php');
    xhr.onload = function() {
      if (xhr.status === 200) {
        const responseText = xhr.responseText.trim();
        if (responseText) {
          const data = JSON.parse(responseText);
          const datalist = document.getElementById("datalistSuppliers");
          datalist.innerHTML = ""; // Limpa as opções existentes
          
          for (const key in data) {
            const optionElement = document.createElement("option");
            optionElement.value = key;
            datalist.appendChild(optionElement);
            const SuppVal = $('#supplierID').attr('value', data[key]);
          }

        } else {
          console.log(responseText);
        }
      }
    };
    xhr.send(formData); // Envie o objeto FormData como dados da solicitação
  }
 
//SEARCH PROJETO

  const projectInput = document.getElementById('projectName');
  projectInput.addEventListener('input', () => {
    searchProject();
  });
  function searchProject() {
    var form = document.getElementById("register_payment"); // Obtenha o elemento do formulário pelo ID
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



// VALOR TOTAL DA PARCELA
  function formatarNumero(numero) {
    return numero.replace('R$ ', '').replace('.', '').replace(',', '.');
  }

  function formatarValor(valor) {
    return valor.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }
  
  function calcularTotal() {
    var inputs = document.getElementsByClassName('catval');
    var total = 0;

    for (var i = 0; i < inputs.length; i++) {
      if (inputs[i].value !== '') {
        var valorFormatado = formatarNumero(inputs[i].value);
        var valorFloat = parseFloat(valorFormatado);
        if (!isNaN(valorFloat) && valorFloat >= 0) {
          total += valorFloat;
        }
      }
    }
    var valorFormatado = formatarValor(total.toFixed(2));
    var valorFinal = `R$ ${valorFormatado}`;
    document.getElementById('valorTotalParcela').value = valorFinal;

    
  }



// impede o envio do formulario
  $(document).on('keydown', function(event) {
    if (event.key === 'Enter') {
      event.preventDefault();
    }
  });


// envia o formulario ao clicar no botao enviar
  $('#register_payment').on('submit', function(event) {
    //if (event.originalEvent.submitter && event.originalEvent.submitter.id === 'sendFormBtn') {
      //event.preventDefault();
      $('#valorTotalParcela').removeAttr('disabled');
      $('#btnSendSpin').removeAttr("hidden");
      $('#sendFormBtn').attr('disabled', 'disabled');
      $('#btnSendName').html('Enviando');
      if ($('#dateIssue').val() === '') {
        $('#dateIssue').attr('disabled', 'disabled');
      }
      setTimeout(function() {
        //insertPayment();
      }, 1500);
      
      
    //} else {
    //  return false;
    //}
  });

//AJAX para retornar JSON de pages/insert_payment
  function insertPayment() {
    var form = document.getElementById("register_payment"); 
    var formData = new FormData(form);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../json/insert_payments.php');
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
          chamaToast('Erro no envio.');
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


  // Ação do botão "Adicionar Categoria"
    $("#btnAdicionarCategoria").click(function() {
      var container = $("#containerCategorias");
      var count = container.children().length + 1;
      var newCategory = $('<div class="form-group mb-3"><div class="row"><div class="col-md-8"><select class="form-control" name="categorias[]"><option value="" disabled selected>Escolha uma categoria</option><optgroup label="Material Fotovoltaico"><option value="2.01.01" class="Mercadoria para Renvenda (KIT/TRAFO)">Mercadoria para Renvenda (KIT/TRAFO)</option><option value="2.01.02" class=""> Frete e Armazenamento de KIT</option></optgroup><optgroup label="Custo de Instalação"><option value="2.02.01" class="Mão de obra"> Mão de obra</option><option value="2.02.02" class="Material C.A"> Material C.A</option><option value="2.02.03" class="Material C.C"> Material C.C</option><option value="2.02.04" class="Custo Não Previsto"> Custo Não Previsto</option><option value="2.02.94" class="Manutenção de Sistemas"> Manutenção de Sistemas</option></optgroup><optgroup label="Custos Extras"><option value="2.02.96" class="Placas de Aviso"> Placas de Aviso</option><option value="2.02.97" class="Projeto e ART"> Projeto e ART</option><option value="2.02.98" class="Visita Técnica"> Visita Técnica</option><option value="2.02.99" class="Frete e Logística de Insumos"> Frete e Logística de Insumos</option><option value="2.03.01" class="Reforma de Padrão" class=""> Reforma de Padrão</option><option value="2.03.02" class="Laudo Estrutural"> Laudo Estrutural</option><option value="2.03.03" class="Obra Civil"> Obra Civil</option><option value="2.03.04" class="Aterramento"> Aterramento</option><option value="2.03.05" class="Locação de Equipamentos"> Locação de Equipamentos</option></optgroup> </select></div><div class="col-md-4"><input type="text" class="form-control catval" name="valorCategoria[]" onblur="calcularTotal()" oninput="calcularTotal()" placeholder="Valor monetário"></div></div></div>');
      container.append(newCategory);
      $('.catval').mask('000.000.000.000.000,00', { reverse: true });
    });



  // Ação do botão "Remover Última Categoria"
    $("#btnRemoverCategoria").click(function() {
      var container = $("#containerCategorias");
      var children = container.children();
      if (children.length > 1) {
        children.last().remove();
      }
    });


  });

</script>
