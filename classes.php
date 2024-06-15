<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud PHP - Sara Verissimo</title>
</head>

<?php

$hostname = "localhost";
$user = "root";
$password = "";
$database = "conexao_php";



$dbconexao = mysqli_connect("$hostname", "$user", "$password") or die("<center>Erro: Não foi possível conectar ao servidor. Por favor, tente novamente mais tarde.</center>");
mysqli_select_db($dbconexao,$database) or die("Banco de dados não encontrado!");

