<?php
$dbconexao = mysqli_connect("localhost", "root", "", "conexao_php");
$mensagem = "";

require("classes.php");

$termo = isset($_GET["edpesquisa"]) ? $_GET["edpesquisa"] : "";
$where = !empty($termo) ? " WHERE nome LIKE '%$termo%' OR email LIKE '%$termo%'" : "";

if (isset($_GET["acao"]) && $_GET["acao"] === "DEL" && isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = mysqli_prepare($dbconexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $mensagem = "Usuário excluído com sucesso!";
    } else {
        $mensagem = "Falha ao excluir usuário.";
    }

    mysqli_stmt_close($stmt);
}

$sql = "SELECT * FROM usuarios $where ORDER BY id, nome, email, senha";
$usuarios = mysqli_query($dbconexao, $sql);

if (!$usuarios) {
    die("Falha ao executar consulta: " . mysqli_error($dbconexao));
}

mysqli_close($dbconexao);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuários</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: lightgray;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            vertical-align: middle;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>
<h1 class="center">Usuários</h1>
<hr>
<a href="usuario_form.php">INCLUIR NOVO USUÁRIO</a>
<br><br>
<form method="GET" action="usuario_lista.php">
    Pesquisar usuário <input autofocus placeholder="Pesquise o usuário aqui" title="Digite parte do nome ou do email aqui" type="text" name="edpesquisa" value="<?= htmlspecialchars($termo) ?>">
    <input type="submit" value="Pesquisar">
</form>
<hr>
<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Comandos</th>
    </tr>
    <?php while ($registro = mysqli_fetch_array($usuarios)) : ?>
        <tr>
            <td><?= htmlspecialchars($registro["id"]) ?></td>
            <td><?= htmlspecialchars($registro["nome"]) ?></td>
            <td><?= htmlspecialchars($registro["email"]) ?></td>
            <td class="center">
                <a title="Excluir usuário" href="javascript:apagar(<?= htmlspecialchars($registro["id"]) ?>);"><img height="24" src="delete.png"></a>&nbsp;
                <a title="Alterar senha do usuário" href="usuario_atualizasenha.php?id=<?= htmlspecialchars($registro["id"]) ?>"><img height="24" src="key.png"></a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
<br>
<a href="index.php">Voltar a Página Principal</a>
<script>
    function apagar(idaexcluir) {
        var resposta = confirm("Você quer realmente excluir o usuário?");
        if (resposta) {
            window.location.replace('usuario_lista.php?acao=DEL&id=' + idaexcluir);
        }
    }

    <?php if (!empty($mensagem)) : ?>
    alert('<?= htmlspecialchars($mensagem) ?>');
    <?php endif; ?>
</script>
</body>
</html>
