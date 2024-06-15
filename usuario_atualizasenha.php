<?php
require("classes.php");

$dbconexao = mysqli_connect("localhost", "root", "", "conexao_php");
$mensagem = "";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = mysqli_prepare($dbconexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);
        $nome = $row["nome"];
        $email = $row["email"];
    } else {
        die("Usuário não encontrado.");
    }

    mysqli_stmt_close($stmt);
} else {
    die("Acesso não autorizado!");
}

if (isset($_POST["id"], $_POST["edsenha"], $_POST["edsenha1"])) {
    $id = $_POST["id"];
    $senha = $_POST["edsenha"];
    $senha1 = $_POST["edsenha1"];

    if ($senha !== $senha1) {
        $mensagem = "As senhas não coincidem!";
    } else {

        $sql = "UPDATE conexao_php SET senha = md5(?) WHERE id = ?";
        $stmt = mysqli_prepare($dbconexao, $sql);
        mysqli_stmt_bind_param($stmt, "si", $senha, $id);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $mensagem = "Senha atualizada com sucesso!";
        } else {
            $mensagem = "Falha ao atualizar senha.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuário - Atualizar senha</title>
</head>
<body>
<h1>Usuário - Atualizar senha</h1>
<hr>
<a href="usuario_lista.php">Listar</a>
<hr>

<form action="usuario_atualizasenha.php" method="POST" id="form1">
    <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
    <table border='1' width="400">
        <tr>
            <td><b>Nome</b></td>
            <td><?= htmlspecialchars($nome) ?></td>
        </tr>
        <tr>
            <td><b>Email</b></td>
            <td><?= htmlspecialchars($email) ?></td>
        </tr>
        <tr>
            <td><b>Nova Senha</b></td>
            <td><input type="password" name="edsenha" id="edsenha" required></td>
        </tr>
        <tr>
            <td><b>Digite a senha novamente</b></td>
            <td><input type="password" name="edsenha1" id="edsenha1" required></td>
        </tr>
    </table>
    <br>
    <input type="button" onclick="verificar()" value="Salvar">
</form>

<script>
    function verificar() {
        var senha = document.getElementById("edsenha").value;
        var senha1 = document.getElementById("edsenha1").value;

        if (senha === "" || senha1 === "") {
            alert("Por favor, preencha ambos os campos de senha.");
            return;
        }

        if (senha !== senha1) {
            alert("As senhas não coincidem. Por favor, preencha novamente.");
            return;
        }

        document.getElementById("form1").submit();
    }

    <?php
    if (!empty($mensagem)) {
        echo "alert('$mensagem');";
    }
    ?>
</script>
</body>
</html>

<?php
mysqli_close($dbconexao);
?>
