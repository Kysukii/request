
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
      

      <div class="col-lg-12 px-0 my-2 table-responsive" id="releases-content" style="display: none;">
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


    </div>

    <!--carregamento da pagina-->
    <div class="container" id="carregamento" style="display: none; margin-top: 5em">
        <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status"> 
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
            
            <form id="formAnexo" method="POST" action="../JSON/insert_doc.php" enctype="multipart/form-data">
              <legend class="fs-6">Enviar arquivos sem acentuação ou caracteres especiais.</legend>
              <div class="row">
                <div class="col-7">
                  <input class="form-control" type="file" name="files[]" />
                </div>
                <div class="col-3">
                  <input id="idOmie" class="form-control" type="text" name="id_omie" hidden/>
                  <input class="form-control" type="text" name="docNumber" placeholder="Numero NF"/>
                </div>
                <div class="col-2">
                  <button class="btn btn-primary" id="sendFormBtn" ><i class="bi bi-send"></i> Enviar</button>
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
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL EXCLUIR LANCAMENTO -->
    <div class="modal modal-lg fade" id="ExluirLancamento" tabindex="-1" aria-labelledby="ExluirLancamento" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5"></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body align-middle text-center mb-5">

            <form id="fExluirLnc" method="POST" action="../JSON/excluir_lancamento.php">
              <div class="row">
                <div class="col-3">
                  <input id="idOmieExc" class="form-control" type="text" name="idOmieExc" disabled/>
                </div>
                <div class="col-5">
                  <input id="FornName" class="form-control" type="text" name="fornName" disabled/>
                </div>
                <div class="col-2">
                  <input id="ValTotal" class="form-control" type="text" name="valTotal" disabled/>
                </div>
                <div class="col-2">
                  <button class="btn btn-danger" id="btnExcluirLanc"><i class="bi bi-send"></i>Excluir</button>
                </div>
              </div>
            </form>
            
          </div>
        </div>
      </div>
    </div>
  
    <!-- toast -->
    <div class="toast-container position-fixed top-0 end-0 p-3"></div>


 



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
    document.getElementById('carregamento').style.display = 'block';
    document.getElementById('releases-content').style.display = 'none';
    
    searchReleases();
  });

  
  document.addEventListener('DOMContentLoaded', function () {
    // Mostrar o indicador de carregamento
    document.getElementById('carregamento').style.display = 'block';
    document.getElementById('releases-content').style.display = 'none';

  });
</script>

<script> //Funções JS 

    function searchSupplier() {
      var form = document.getElementById("search_releases"); // Obtenha o elemento do formulário pelo ID
      var formData = new FormData(form); // Crie um objeto FormData para enviar o formulário

      const xhr = new XMLHttpRequest();
      xhr.open('POST', '../JSON/search_supplier.php');
      xhr.onload = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          document.getElementById('carregamento').style.display = 'none';
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
          document.getElementById('releases-content').style.display = 'block';
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
        if (xhr.readyState === 4 && xhr.status === 200) {
          document.getElementById('carregamento').style.display = 'none';
          const responseText = xhr.responseText.trim();
          if (responseText) {
            try {
              const releases = JSON.parse(responseText); // Parse do JSON retornado para um array de objetos
              //document.getElementById("releases-content").textContent = releases;
              var tabela = $("#tabelaLancamentos").find('tbody');
              tabela.empty();
              
              // Loop pelos lançamentos
              
              releases.forEach(function(lancamento) {
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
                  linha.append($("<td>").append($("<button type='button' class='btn btn-danger btn-sm' title='Excluir Lançamento' onclick='excluirlancamento(\"" + lancamento['id Omie'] + "\", \"" + lancamento['Nome Fornecedor'] + "\", \"" + lancamento['valor total'] + "\")'><i class='bi bi-trash'></i></button>")));
                }else {
                  linha.append($("<td>"));
                }
                if (lancamento['anexos'] && Array.isArray(lancamento['anexos'])) {
                  const fileNameJSON = lancamento['anexos'].map(function(anexo) {
                    return anexo['cNomeArquivo'];
                  });

                    linha.append(
                      $("<td>").append(
                        $("<button type='button' class='btn btn-secondary btn-sm' title='Inserir Anexo' onclick='chamaModal(" + JSON.stringify(fileNameJSON) + "," + lancamento['id Omie'] + ")'><i class='bi bi-file-earmark-arrow-up'></i></button>")
                      )
                    );
                }else {
                  linha.append(
                    $("<td>").append(
                        $("<button type='button' class='btn btn-secondary btn-sm' title='Inserir Anexo' onclick='chamaModal(" + null + "," + lancamento['id Omie'] + ")'><i class='bi bi-file-earmark-arrow-up'></i></button>")
                      )
                    );
                }
                
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
        document.getElementById('releases-content').style.display = 'block';
      };
      xhr.send(formData); // Envie o objeto FormData como dados da solicitação
    }
    
    function getAnexo() {
      var form = document.getElementById("formAnexo"); 
      var formData = new FormData(form);

      const xhr = new XMLHttpRequest();
      xhr.open('POST', '../json/insert_doc.php');
      xhr.onload = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          document.getElementById('carregamento').style.display = 'none';

          const responseText = xhr.responseText.trim();
          
          if (responseText) {
            const data = JSON.parse(responseText);
            const messages = [];
            for (var key in data) {
              const chave = key;
              if (chave == 'faultstring') {
                messages.push(data[key]);
              } else {
                messages.push(data[key]);
                
              }
            }
            chamaToast(messages);
            console.log(messages);
          } else {
            console.log(responseText);
            chamaToast('Erro no envio.');
          }
        }
        document.getElementById('releases-content').style.display = 'block';
      };
      xhr.send(formData);
    }

    function chamaModal(fileNameJSON, codOmie) {
      var modalElement = document.getElementById('AnexarItem');
      var modalInstance = new bootstrap.Modal(modalElement);
      const modalTitle = document.querySelector('#AnexarItem .modal-title');
      modalTitle.textContent = "Lançamento número " + codOmie;

      var tabAnexos = $("#tabAnexos").find('tbody');
      tabAnexos.empty();
      
      if (Array.isArray(fileNameJSON)) { // Verifique se fileNameJSON é um array
          fileNameJSON.forEach(function(anexo) {
              var rowAnexo = $("<tr>");
              rowAnexo.append($("<td>").text(anexo));
              tabAnexos.append(rowAnexo);
          });
      }
      
      $('#idOmie').val(codOmie);
      
      modalInstance.show();
    }

  
    function chamaToast(message) {
      const toastContainer = document.querySelector('.toast-container');
      
      const newToast = document.createElement('div');
      newToast.className = 'toast';
      
      newToast.innerHTML = `
        <div class="toast-header">
          <strong class="me-auto">Mensagem</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">${message}</div>
      `;
      
      toastContainer.appendChild(newToast);
      
      const toastInstance = new bootstrap.Toast(newToast);
      toastInstance.show();
    }

    function excluirlancamento(codOmie, favorecido, valLanc) {

      var modalElement = document.getElementById('ExluirLancamento');
      var modalInstance = new bootstrap.Modal(modalElement);
      const modalTitle = document.querySelector('#ExluirLancamento .modal-title');
      modalTitle.textContent = "Tem certeza que deseja excluir o lançamento?";

      $('#idOmieExc').val(codOmie);
      $('#FornName').val(favorecido);
      $('#ValTotal').val(valLanc);    

      modalInstance.show();

      $('#fExluirLnc').submit(function(event) {
        event.preventDefault();
        
        var form = document.getElementById("fExluirLnc"); 
        var formData = new FormData(form);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../json/excluir_lancamento.php');
        xhr.onload = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            $('.modal-content .modal-body').html('<h4>Excluindo lançamento..... Aguarde!</h4>');
            $('#btnExcluirLanc').attr('disabled', 'disabled');

            const responseText = xhr.responseText.trim();
            
            if (responseText) {
              const data = JSON.parse(responseText);
              const messages = [];
              for (var key in data) {
                const chave = key;
                if (chave == 'faultstring') {
                  messages.push(data[key]);
                } else {
                  messages.push(data[key]);
                }
              }
              $('.modal-content .modal-body').html(messages);

              setTimeout(function () {
                location.reload();
              }, 1000);
            } else {
              console.log(responseText);
              $('.modal-content .modal-body').html("Erro na Exclusão.");
            }
          }
        };
        xhr.send(formData);
     
      });

    }

    const supplierInput = document.getElementById('supplierName');
    supplierInput.addEventListener('input', () => {
      searchSupplier();
    });


    $(document).on('keydown', function(event) {
      if (event.key === 'Enter') {
        event.preventDefault();
      }
    });

    $('#formAnexo').on('submit', function(event) {
      if (event.originalEvent.submitter && event.originalEvent.submitter.id === 'sendFormBtn') {
        event.preventDefault();
        getAnexo();
        var form = document.getElementById("formAnexo"); 
        form.reset();
      } 
    });
  
  
</script>''