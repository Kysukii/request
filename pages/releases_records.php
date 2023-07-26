
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
              <input class="form-control" type="text" name="supplierID" id="supplierName"/>
            </div>
            <div class="col-1 mb-3">
              <label for=""></label>
              <button type="submit" class="btn btn-primary form-control py-0"><i class="bi bi-arrow-right-circle-fill fs-4"></i></button>
            </div>
          </div>
        </form>
      </div>
      

      <div class="col-lg-12 px-0 my-2" id="releases-content">
        <table id="tabelaLancamentos" class="table">
          <thead style="text-align: center;">
            <tr>
              <th>Status</th>
              <th>Cliente</th>
              <th>Data Vencimento</th>
              <th>Data Previsao</th>
              <th>Categoria</th>
              <th>Valor da Categoria</th>
              <th>Id Projeto</th>
              <th>N Doc</th>
              <th>Valor Total</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody style="text-align: center;">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="../main.js"></script>
  </body>
</html>


<script> //scripts jquery
  $(document).ready(function() {
  //DEFINIR DATA NOS INPUTS DE ENTRADA DataDe e DataAte
    var hoje = new Date();
    var ontem = new Date();
    ontem.setDate(ontem.getDate() - 2);
    var data30 = new Date();
    data30.setDate(data30.getDate() + 30);
    var dataontem = ontem.toISOString().slice(0, 10);
    var data30 = data30.toISOString().slice(0, 10);
    document.getElementById("dataDe").value = dataontem;
    document.getElementById("dataAte").value = data30;


    searchReleases();
  });

  $('#search_releases').submit(function(event) {
    event.preventDefault();
    searchReleases();
  
    //document.getElementById('cadastro_forn').reset();
  });
</script>

<script> //scripts js
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

          // Limpar a tabela antes de inserir os novos dados
          tabela.empty();

          // Loop pelos lançamentos
            releases.forEach(function(lancamento) {
            var linha = $("<tr>");
            linha.append($("<td>").text(lancamento['status']));
            linha.append($("<td>").text(lancamento['Codigo Cliente']));
            linha.append($("<td>").text(lancamento['Data Vencimento']));
            linha.append($("<td>").text(lancamento['Data Previsao']));
            linha.append($("<td>").text(lancamento['categorias'][0]['categoria']));
            linha.append($("<td>").text(lancamento['categorias'][0]['cat_valor']));
            linha.append($("<td>").text(lancamento['Id Projeto']));
            linha.append($("<td>").text(lancamento['ndoc']));
            linha.append($("<td>").text(lancamento['valor total']));
            if (lancamento['status'] === "A VENCER" || lancamento['status'] === "VENCE HOJE") {
              linha.append($("<td>").append($("<button type='button' class='form-control btn btn-danger'>").text("Excluir")));
            }else {
              linha.append($("<td>"));
            }
            
            // Adicione mais colunas aqui conforme necessário
            console.log(lancamento);
            tabela.append(linha);
          });
        } catch (error) {
          console.error('Erro ao analisar a resposta JSON:', error);
          alert('Erro ao analisar a resposta JSON.');
        }
      } else {
        alert('Erro no envio.');
      }
    }
  };
  xhr.send(formData); // Envie o objeto FormData como dados da solicitação
}

  
</script>