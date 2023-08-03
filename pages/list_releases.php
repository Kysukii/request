
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
  <body>
    <div class="container my-3">
      <div class="col-lg-12 px-0">
        <form method="POST" action="../JSON/records_releases.php" id="search_releases">
          <div class="row" style="text-align: center; font-weight: bolder;">
            <div class="col-2 mb-3">
              <label for="status">Status:</label>
              <select class="form-control" id="status" name="docStatus">
                <option selected value="EMABERTO">EM ABERTO</option>
                <option value="PAGO">PAGO</option>
                <option value="CANCELADO">CANCELADO</option>
                <option value="PAGTO_PARCIAL">PAGTO PARCIAL</option>
                <option value="VENCEHOJE">VENCE HOJE</option>
                <option value="AVENCER">AVENCER</option>
                <option value="ATRASADO">ATRASADO</option>
              </select>
            </div>
            <div class="col-2 mb-3">
              <label for="dataDe">Data De:</label>
              <input class="form-control" type="date" name="dataDe" id="dataDe"/>
            </div>
            <div class="col-2 mb-3">
              <label for="dataAte">Data Até:</label>
              <input class="form-control" type="date" name="dataAte" id="dataAte"/>
            </div>
            <div class="col-5 mb-3">
              <label for="supplierID">Fornecedor:</label>
              <input class="form-control" list="datalistSuppliers" id="supplierName" name="supplier_name" placeholder="Digite para Procurar...">
              <input class="form-control" id="supplierID" name="supplier_ID" hidden>
              <datalist id="datalistSuppliers">
              </datalist>
            </div>
            <div class="col-1 mb-3">
              <label for=""></label>
              <button type="submit" class="btn btn-primary form-control"><i class="bi bi-search"></i></button>
            </div>
          </div>
        </form>
      </div>
      

      <div class="col-lg-12 px-0 my-2 table-responsive" id="releases-content">
        <table id="tabelaLancamentos" class="table table-striped table-hover align-middle">
          <thead class="text-center">
            <tr>
              <th scope="col">Data Inc.</th>
              <th scope="col">Status</th>
              <th scope="col">Razão Social</th>
              <th scope="col">Vencimento</th>
              <th scope="col">Previsão</th>
              <th scope="col">ID Bitrix</th>
              <th scope="col">N Doc</th>
              <th scope="col">Valor Total</th>
              <th scope="col" colspan="2">Action</th>
            </tr>
          </thead>
          <tbody class="text-center" style="font-size: 10pt;">
            <!-- Aqui as linhas da tabela serão criadas dinamicamente -->
          </tbody>
        </table>
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


    <!-- Modal ANEXAR documento -->
    <div class="modal modal-lg fade" id="AnexarItem" tabindex="-1" aria-labelledby="AnexarItemLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="AnexarItemLabel">Anexos do Lançamento</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body align-middle text-center">
            
            <form method="POST" action="" multipart>
              <legend class="fs-6">Enviar arquivos sem acentuação ou caracteres especiais.</legend>
              <div class="row">
                <div class="col-7">
                  <input class="form-control" type="file" name="insert_anexo"/>
                </div>
                <div class="col-3">
                  <input class="form-control" type="text" name="docNumber" placeholder="Numero NF"/>
                </div>
                <div class="col-2">
                  <button class="btn btn-primary"><i class="bi bi-send"></i> Enviar</button>
                </div>
              </div>
            </form>
            
            <div class="col-lg-12 px-0 my-3 table-responsive" id="releases-content">
              <table id="tabAnexos" class="table table-striped table-hover align-middle text-center">
                <thead class="text-center">
                  <tr>
                    <th>Descrição</th>
                  </tr> 
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="../main.js"></script>
  </body>
</html>


<script> //scripts
  let fileName;
  $(document).ready(function() {

  //DEFINIR DATA NOS INPUTS DE ENTRADA DataDe e DataAte
    var hoje = new Date();
    var ontem = new Date();
    ontem.setDate(ontem.getDate() - 5);
    var data30 = new Date();
    data30.setDate(data30.getDate() + 0);
    var dataontem = ontem.toISOString().slice(0, 10);
    var data30 = data30.toISOString().slice(0, 10);
    document.getElementById("dataDe").value = dataontem;
    document.getElementById("dataAte").value = data30;

    searchReleases();
  });

  $('#search_releases').submit(function(event) {
    event.preventDefault();
    searchReleases();
  });
</script>

<script> //Funções JS 
  function chamaModal (fileNameJSON, codSupplier) {
    
    var modalElement = document.getElementById('AnexarItem');
    var modalInstance = new bootstrap.Modal(modalElement);
    const modalTitle = document.querySelector('#AnexarItem .modal-title');
    modalTitle.textContent = "Lançamento número " + codSupplier;

    var tabAnexos = $("#tabAnexos").find('tbody');
    tabAnexos.empty();
    
    fileNameJSON.forEach(function(anexo) {
      var rowAnexo = $("<tr>");
      rowAnexo.append($("<td>").text(anexo));
      tabAnexos.append(rowAnexo);
      console.log(anexo);
    });
    

    modalInstance.show();
  }
  
  function chamaToast(text) {
    const toast = document.querySelector('.toast');
    var toastInstance = new bootstrap.Toast(toast);
    $('.toast-body').html(text);
    toastInstance.show();
  }


  const supplierInput = document.getElementById('supplierName');
  supplierInput.addEventListener('input', () => {
    searchSupplier();
  });

  function searchSupplier() {
    var form = document.getElementById("search_releases"); // Obtenha o elemento do formulário pelo ID
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
            if ($('#supplierName').val() === "") {
              $('#supplierID').val(""); 
            }else {
              $('#supplierID').val(data[key]);
              const SuppVal = $('#supplierID').attr('value', data[key]);
            }
            
          }

        } else {
          console.log(responseText);
        }
      }
    };
    xhr.send(formData); // Envie o objeto FormData como dados da solicitação
  }

  function searchReleases() {
    var form = document.getElementById("search_releases"); // Obtenha o elemento do formulário pelo ID
    var formData = new FormData(form); // Crie um objeto FormData para enviar o formulário

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../json/records_releases.php');
    xhr.onload = function() {
      if (xhr.status === 200) {
        const responseText = xhr.responseText.trim();
        if (responseText) {
          try {
            const releases = JSON.parse(responseText); // Parse do JSON retornado para um array de objetos
            //document.getElementById("releases-content").textContent = releases;
            var tabela = $("#tabelaLancamentos").find('tbody');
            tabela.empty();
            
            // Loop pelos lançamentos
            releases.forEach(function(lancamento) {
              console.log(lancamento);
              var linha = $("<tr>");
              linha.append($("<td>").text(lancamento['Data Inc.']));
              linha.append($("<td>").text(lancamento['status']));
              linha.append($("<td>").text(lancamento['Nome Fornecedor']));
              linha.append($("<td>").text(lancamento['Data Vencimento']));
              linha.append($("<td>").text(lancamento['Data Previsao']));
              linha.append($("<td>").text(lancamento['Id Bitrix']));
              linha.append($("<td>").text(lancamento['ndoc']));
              linha.append($("<td>").text('R$ '+lancamento['valor total']));
              if (lancamento['status'] === "A VENCER" || lancamento['status'] === "VENCE HOJE") {
                linha.append($("<td>").append($("<button type='button' class='btn btn-danger btn-sm' title='Excluir Lançamento'><i class='bi bi-trash'></i></button>")));
              }else {
                linha.append($("<td>"));
              }
              const fileNameJSON = lancamento['anexos'].map(function(anexo) {
                return anexo['cNomeArquivo'];
              });
              
              linha.append(
                $("<td>").append(
                  $("<button type='button' class='btn btn-secondary btn-sm' title='Inserir Anexo' onclick='chamaModal(" + JSON.stringify(fileNameJSON) + ", " + lancamento['Codigo Cliente'] + ")'><i class='bi bi-file-earmark-arrow-up'></i></button>")
                )
              );
              tabela.append(linha);
            });
            

          } catch (error) {
            console.error('Erro ao analisar a resposta JSON:', error);
            chamaToast('Nenhum resultado Encontrado.');
          }
        } else {
          alert('Erro no envio.');
        }
      }
    };
    xhr.send(formData); // Envie o objeto FormData como dados da solicitação
  }

  
</script>