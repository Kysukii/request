<?php


$supplier_name = $_POST['supplier_name'];
$banks = $_POST['banks'];
$due_date = $_POST['due_date'];
$project = $_POST['projects_name'];
$categorias = $_POST['categorias'];
$valor = $_POST['valor'];
$requester = $_POST['requester'];
$TotalParcela = $_POST['TotalParcela'];
$files = $_FILES['files'];
$numNF = $_POST['numNF'];
$issueDate = $_POST['issueDate'];
$observation = $_POST['observation'];

echo $supplier_name."</BR>";
echo $banks."</BR>";
echo $due_date."</BR>";
echo $project."</BR>";
echo $categorias."</BR>";
echo $valor."</BR>";
echo $requester."</BR>";
echo $TotalParcela."</BR>";
echo $files."</BR>";
echo $numNF."</BR>";
echo $issueDate."</BR>";
echo $observation."</BR>";
?>