<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  </head>
  <body>
  <?php
    include("pages/navbar.php");
  ?>
    <div class="container my-5">
      <h1>Formulário - Ordem de pagamento</h1>
      <div class="col-lg-8 px-0">

        <form id="register_payment" action="../JSON/search_supplier.php" method="POST">
        <legend>Envio de requisições para a OMIE</legend>
        <div class="form-group">
            <label for="repetitions">Quantidade de Repetições:</label>
            <input type="number" class="form-control" id="repetitions" name="repetitions">
        </div>
        <div id="pagination-container">
            <!-- Aqui serão inseridas as páginas -->
        </div>
        <ul id="pagination" class="pagination"></ul>
        
        
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
            <label for="null" class="form-label">Adicionar Categorias:</label>
            <div class="gap-3 d-flex justify-content-center">
                <button class="btn btn-primary col-5 btnAdicionarCategoria" data-container="containerCategorias">ADD</button>
                <button class="btn btn-danger col-5" id="btnRemoverCategoria">DEL</button>
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
            
          </div> 
        </div>
        

        <div class="row">
          <div class="col-12 mb-2">
          <label class="form-label" for="floatingTextarea" style="margin-left: 5px;">Observação:</label>
            <textarea class="form-control" placeholder="Digitar um Comentário" id="floatingTextarea"></textarea>
              
          </div>
        </div>

            <hr class="col-12 my-4"> 
          <input id="sendFormBtn" class="btn btn-primary" type="submit" value="Enviar"/>
        </form>

      </div>
    </div>
  
  

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      var currentPage = 1;
      var numPages = 0;
      var formFields = [];
      var formData = {}; // Variável para armazenar os valores dos campos

      $('#sendFormBtn').on('click', function() {
        console.log(formData);
      });

      $('#register_payment').on('submit', function(e) {
        e.preventDefault();
      });

      $('#repetitions').on('change', function() {
        var newNumPages = parseInt($(this).val());
        if (newNumPages < 1) {
          return;
        }
        numPages = newNumPages;
        currentPage = 1;
        updatePagination();
      });

      $('#pagination').on('click', 'li.page-item', function() {
        var targetPage = parseInt($(this).find('a.page-link').text());
        if (targetPage === currentPage) {
          return;
        }
        saveFormData(currentPage); // Salva os valores dos campos antes de navegar para outra página
        currentPage = targetPage;
        updatePagination();
        restoreFormData(currentPage); // Restaura os valores dos campos
      });

      function updatePagination() {
        $('#pagination-container').empty();
        $('#pagination').empty();

        for (var i = 1; i <= numPages; i++) {
          var page = $('<div class="page"></div>');
          var heading = $('<h3>Página ' + i + '</h3>');
          var fieldset = $('<fieldset></fieldset>');

          // Copie os campos do formulário original para cada página apenas na primeira vez
          if (formFields.length === 0) {
            formFields = $('#register_payment .form-group').clone();
          }

          formFields.find(':input').each(function() {
            var originalId = $(this).attr('id');
            var pageId = originalId + '-' + i;
            var clonedField = $(this).clone();
            clonedField.attr('id', pageId);
            clonedField.attr('name', pageId);

            // Verifica se há um valor salvo para o campo e atualiza o valor do campo clonado
            if (formData[originalId] && formData[originalId][i]) {
              clonedField.val(formData[originalId][i]);
            }

            fieldset.append(clonedField);
          });

          page.append(heading);
          page.append(fieldset);

          if (i === currentPage) {
            page.addClass('active');
          } else {
            page.hide();
          }

          $('#pagination-container').append(page);
          $('#pagination').append('<li class="page-item"><a class="page-link" href="#">' + i + '</a></li>');
        }

        // Atualiza a classe 'active' do botão de paginação
        $('#pagination li.page-item').removeClass('active');
        $('#pagination li.page-item:nth-child(' + currentPage + ')').addClass('active');
      }

      function saveFormData(page) {
        $('#register_payment .form-group :input').each(function() {
          var originalId = $(this).attr('id');
          var pageId = originalId + '-' + page;
          if (!formData[originalId]) {
            formData[originalId] = {};
          }
          formData[originalId][page] = $('#' + pageId).val();
        });
      }

      function restoreFormData(page) {
        $('#register_payment .form-group :input').each(function() {
          var originalId = $(this).attr('id');
          var pageId = originalId + '-' + page;
          if (formData[originalId] && formData[originalId][page]) {
            $('#' + pageId).val(formData[originalId][page]);
          }
        });
      }
    });
  </script>
</body>
</html>
