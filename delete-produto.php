<?php
require_once "src/conexao-bd.php";
require_once "src/Model/Produto.php";
require_once "src/Repositorio/ProdutoRepositorio.php";

$pdo = new ProdutoRepositorio($pdo);

$pdo->deleteProduto($_POST['id']);
header("Location: admin.php");
