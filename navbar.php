<?php

if ($_SERVER['REQUEST_URI'] == "/request-1/index.php") {
  $home = "index.php";
  $op = "pages/payments_register.php";
  $rs = "pages/register_supplier.php";
  $lc = "pages/list_releases.php";
  $art = "pages/register_art.php";
}else {
  $home = "../index.php";
  $op = "payments_register.php";
  $rs = "register_supplier.php";
  $lc = "list_releases.php";
  $art = "register_art.php";
}

?>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="#">Getpower</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">

            <?php
            echo '
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="'.$home.'">Home</a>
            </li>

            
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Formulario
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="'.$op.'">Ordem Pagamento</a></li>
                <li><a class="dropdown-item" href="'.$art.'">Enviar ART</a></li>
                <li><a class="dropdown-item" href="'.$rs.'">Cadastrar Fornecedor</a></li>
              </ul>
            </li>
           
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="'.$lc.'">Listar Lançamentos</a>
            </li>'
            ?>
          </ul>

        </div>
      </div>
    </nav>