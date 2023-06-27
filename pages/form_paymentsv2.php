
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  </head>
  <body>
  <?php
    include("navbar.php");
  ?>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div ID="toastBody" class="toast-body">
      Hello, world! This is a toast message.
      </div>
      <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

    <div class="container my-5">
      <h1>Formulário - Ordem de pagamento</h1>
      <div class="col-lg-8 px-0">
        <form id="register_payment" action="../JSON/search_supplier.php" method="POST">
        <legend>Envio de requisições para a OMIE</legend>
        

        <div class="accordion" id="accordionParcel">
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Parcela 1
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionParcel">
              <div class="accordion-body">

                <div class="row">
                  <div class="col-8 mb-3">
                    <label for="supplierName" class="form-label">Fornecedor:</label>
                      <input name="supplier_name" class="form-control" list="datalistSuppliers" id="supplierName" placeholder="Digite para Procurar...">
                      <datalist id="datalistSuppliers">
                      </datalist>
                  </div>
                  <div class="col-4 mb-3">
                  <label for="projectName" class="form-label">Banco:</label>
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
                    <input name="projects_name" class="form-control" id="projectName" placeholder="ID do BITRIX">
                  </div>
                  <div class="col-4 mb-3" style="text-align: center;">
                    <label for="null" class="form-label">Valor total da Parcela:</label>
                    <div class="gap-3 d-flex justify-content-center">
                  </div>
                </div>

                <div class="row">
                  <div id="containerCategorias" >
                    <div class="row">
                      <div class="col-8 mb-3">
                        <label for="catOne" class="form-label">Categoria:</label>
                        <input type="text" class="form-control" name="categoria[]" placeholder="Categoria 1" id="catOne">
                      </div>
                      <div class="col-4 mb-3">
                        <label for="catVal" class="form-label">Valor:</label>
                        <input type="text" class="form-control" name="valor[]" placeholder="Valor monetário" id="catVal">
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-3 mb-2">
                    <label for="supplierName" class="form-label">Solicitante:</label>
                    <select class="form-control">
                      <option>Carlos Magno</option>
                    </select>
                    
                  </div>

                
                  <div class="col-3 mb-2 ">
                    <label for="nDoc" class="form-label">N Doc:</label>
                    <input name="projects_name" class="form-control" id="nDoc" placeholder="ID do BITRIX">
                  </div>
                  <div class="col-6 mb-2">
                    <input hidden name="projects_name" class="form-control" disabled list="datalistProjects" id="projectName" placeholder="ID do BITRIX" value="x">
                    <label for="files" class="form-label">Enviar Anexos:</label>
                    <input type="file" name="files[]" class="form-control" id="files" placeholder="Enviar Arquivo" multiple>
                  </div>
                </div>


                <div class="row">
                  <div class="col-12 mb-2">
                  <label class="form-label" for="floatingTextarea" style="margin-left: 5px;">Observação:</label>
                    <textarea class="form-control" placeholder="Digitar um Comentário" id="floatingTextarea"></textarea>
                      
                  </div>
                  
                </div>
                
              </div>
            </div>
          </div>
          
          <div class="accordion" id="accordionParc">

          </div>
        </div>

        
            <div class="col-2 mb-2">
              <label for="parcelas" class="form-label">Repetição</label>
              <input type="number" min="1" max="20" name="parcelas" class="form-control" id="addParcel" value="1">
            </div>

            <hr class="col-12 my-4"> 
          <input id="sendFormBtn" class="btn btn-primary" type="submit" value="Enviar"/>
        </form>

      </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="../main.js"></script>
    <script>
      $('#register_payment').submit(function(event) {
        event.preventDefault();
        //searchSupplier();
        //document.getElementById('cadastro_forn').reset();

      });

      $(document).ready(function() {

        // Ação quando o número de parcelas é alterado
        $("#addParcel").change(function() {
          var numParcelas = $(this).val();
          var container = $("#accordionParc");
          container.empty(); // Limpa os campos existentes
          if (numParcelas> 0 && numParcelas<21) {
            for (var i = 2; i <= numParcelas; i++) {

              var divAccItem = $("<div>").html(`<div class="accordion-item">
              <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse` + i + `" aria-expanded="true" aria-controls="collapse` + i + `">
                Parcela ` + i + `
              </button>
            </h2>
            <div id="collapse` + i + `" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionParcel">
              <div class="accordion-body">

                <div class="row">
                  <div class="col-8 mb-3">
                    <label for="supplierName" class="form-label">Fornecedor:</label>
                      <input name="supplier_name[]" class="form-control" list="datalistSuppliers" id="supplierName" placeholder="Digite para Procurar...">
                      <datalist id="datalistSuppliers">
                      </datalist>
                  </div>
                  <div class="col-4 mb-3">
                  <label for="projectName" class="form-label">Banco:</label>
                    <select name="banks[]" id="banks" name="banks" class="form-control">
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
                      <input type="date" name="due_date[]" class="form-control" id="dueDate">
                  </div>
                  <div class="col-4 mb-3">
                    <label for="projectName" class="form-label">Projeto:</label>
                    <input name="projects_name[]" class="form-control" id="projectName" placeholder="ID do BITRIX">
                  </div>
                  <div class="col-4 mb-3" style="text-align: center;">
                    <label for="null" class="form-label">Valor total da Parcela:</label>
                    <div class="gap-3 d-flex justify-content-center">
                      <input type='value' class="form-control" disabled value="51545"/>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div id="containerCategorias" >
                    <div class="row">
                      <div class="col-8 mb-3">
                        <label for="catOne" class="form-label">Categoria:</label>
                        <input type="text" class="form-control" name="categoria[]" placeholder="Categoria 1" id="catOne">
                      </div>
                      <div class="col-4 mb-3">
                        <label for="catVal" class="form-label">Valor:</label>
                        <input type="text" class="form-control" name="valor[]" placeholder="Valor monetário" id="catVal">
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-3 mb-2">
                    <label for="supplierName" class="form-label">Solicitante:</label>
                    <select class="form-control">
                      <option>Carlos Magno</option>
                    </select>
                    
                  </div>

                
                  <div class="col-3 mb-2 ">
                    <label for="nDoc" class="form-label">N Doc:</label>
                    <input name="projects_name" class="form-control" id="nDoc" placeholder="ID do BITRIX">
                  </div>
                  <div class="col-6 mb-2">
                    <input hidden name="projects_name" class="form-control" disabled list="datalistProjects" id="projectName" placeholder="ID do BITRIX" value="x">
                    <label for="files" class="form-label">Enviar Anexos:</label>
                    <input type="file" name="files[]" class="form-control" id="files" placeholder="Enviar Arquivo" multiple>
                  </div>
                </div>


                <div class="row">
                  <div class="col-12 mb-2">
                  <label class="form-label" for="floatingTextarea" style="margin-left: 5px;">Observação:</label>
                    <textarea class="form-control" placeholder="Digitar um Comentário" id="floatingTextarea"></textarea>
                      
                  </div>
                  
                </div>
                
              </div>`);
            
              container.append(divAccItem);
            }
          }

        });



      });
      const toastLiveExample = document.getElementById('liveToast');
      const toastContent = document.getElementById('toastBody');

      const toastBootstrap = new bootstrap.Toast(toastLiveExample);

      //const toastTrigger = document.getElementById('sendFormBtn');
      // toastTrigger.addEventListener('click', () => {
      //   alert('Ola mundo!');
      // });

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
              updatedatalistSuppliers(data);
            } else {
              //toastContent.innerHTML = JSON.stringify(data);
              //toastBootstrap.show();

            }
          }
        };
        xhr.send(formData); // Envie o objeto FormData como dados da solicitação
      }

      function updatedatalistSuppliers(data) {
        const datalist = document.getElementById("datalistSuppliers");
        datalist.innerHTML = ""; // Limpa as opções existentes

        for (const key in data) {
          const optionElement = document.createElement("option");
          optionElement.value = key;
          optionElement.innerText = data[key];
          datalist.appendChild(optionElement);
        }
      }


    </script>
    
  </body>
</html>


