<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
  <?php
    require_once("navbar.php");
  ?>

    <div class="container my-5">
      <h1>Lançamentos Financeiros</h1>
      <div class="col-lg-8 px-0">
        <p class="fs-5">Simplificando a Gestão Financeira</p>
        <p>Esta página é a sua ferramenta central para registrar e monitorar todas as compras e pagamentos feitas pela Getpower.</p>
        <ul>
          <li><strong>Controle Total:</strong> Mantenha o controle completo as despesas, registrando todos os gastos de forma organizada.</li>
          <li><strong>Transparência:</strong> Garanta transparência em todas as transações, permitindo que todos os envolvidos tenham acesso às informações financeiras necessárias.</li>
          <li><strong>Conformidade Fiscal:</strong> Cumpra com todas as obrigações fiscais, armazenando as notas fiscais de maneira segura e acessível.</li>
        </ul>
        <p>Nossa plataforma simplifica o processo de lançamento de despesas e facilita a gestão financeira.</p>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="main.js"></script>
  </body>
</html>
