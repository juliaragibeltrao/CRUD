<?php
require("classes.php");

$acao = "I";
$inputid = "";
$nome = "";
$email = "";
$senha = "";
$mensagem = "";

$dbconexao = new mysqli("localhost", "root", "", "conexao_php");

if ($dbconexao->connect_error) {
    die("Falha na conexão: " . $dbconexao->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $acao = $_POST["acao"];

    $nome = $dbconexao->real_escape_string($_POST["ednome"]);
    $email = $dbconexao->real_escape_string($_POST["edemail"]);

    if ($acao == "I") {

        $senha = password_hash($dbconexao->real_escape_string($_POST["edsenha"]), PASSWORD_BCRYPT);

        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $dbconexao->prepare($sql);
        $stmt->bind_param("sss", $nome, $email, $senha);

        if ($stmt->execute()) {
            $acao = "A";
            $id = $stmt->insert_id;
            $inputid = "<input type='hidden' name='id' value='$id'>";
            $mensagem = "Usuário incluído com sucesso!";
        } else {
            die("Falha ao rodar sql: " . $stmt->error);
        }

        $stmt->close();
    }

    if ($acao == "A") {
        $inputid = "<input type='hidden' name='id' value='$id'>";

        $sql = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
        $stmt = $dbconexao->prepare($sql);
        $stmt->bind_param("ssi", $nome, $email, $id);

        if ($stmt->execute()) {
            $mensagem = "Usuário atualizado com sucesso!";
        } else {
            die("Falha ao rodar sql: " . $stmt->error);
        }

        $stmt->close();
    }

    if ($acao == "E") {
        $id = $_POST["id"];
        $inputid = "";

        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $dbconexao->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $acao = "I";
            $nome = "";
            $email = "";
            $senha = "";
            $mensagem = "Usuário excluído com sucesso!";
        } else {
            die("Falha ao rodar sql: " . $stmt->error);
        }

        $stmt->close();
    }

} else {

    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $sql = "SELECT * FROM conexao_php WHERE id = ?";
        $stmt = $dbconexao->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $acao = "A";
                $inputid = "<input type='hidden' name='id' value='$id'>";
                $nome = $row["nome"];
                $email = $row["email"];
            }
        } else {
            die("Falha ao rodar sql: " . $stmt->error);
        }

        $stmt->close();
    }
}

$dbconexao->close();
?>

<h1>Usuário</h1>

<hr>
<a href="usuario_lista.php">Listar</a>
<br>
<a href="index.php">Voltar a Página Principal</a>
<hr>

<form action="usuario_form.php" method="POST" id="form1">

    <table border='1' width="400">
        <input type="hidden" name="acao" id="acao" value="<?php echo $acao; ?>">

        <?php echo $inputid; ?>

        <tr>
            <td><b>Nome</b></td>
            <td><input type="text" name="ednome" id="ednome" value="<?php echo $nome; ?>" required></td>
        </tr>
        <tr>
            <td><b>Email</b></td>
            <td><input type="email" name="edemail" id="edemail" value="<?php echo $email; ?>" required></td>
        </tr>

        <?php if ($acao == "I") { ?>
            <tr>
                <td><b>Senha</b></td>
                <td><input type="password" name="edsenha" id="edsenha" required></td>
            </tr>
            <tr>
                <td><b>Digite a senha novamente</b></td>
                <td><input type="password" name="edsenha1" id="edsenha1" required></td>
            </tr>
        <?php } ?>

    </table>

    <br>

    <input type="button" onclick="verificar()"  value="Salvar"/>
    <?php if ($acao == "A") { ?>
        <input type="button" onclick="excluir()"  value="Excluir"/>
        <input type="button" onclick="atualizasenha(<?php echo $id; ?>)"  value="Alterar senha"/>
    <?php } ?>
</form>

<script>

    function validaremail(email) {
        var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    function verificar(){
        var nome = document.getElementById("ednome");
        var email = document.getElementById("edemail");

        <?php if ($acao == "I") { ?>
        var senha = document.getElementById("edsenha");
        var senha1 = document.getElementById("edsenha1");
        <?php } ?>

        if (nome.value == ""){
            alert("O nome é obrigatório!");
            return;
        }
        if (email.value == ""){
            alert("O email é obrigatório!");
            return;
        }
        if (!validaremail(email.value)){
            alert("O email é inválido! Favor colocar no formato 'a@b.c'");
            return;
        }
        <?php if ($acao == "I") { ?>
        if (senha.value == ""){
            alert("O valor da senha é obrigatório!");
            return;
        }
        if (senha.value == senha1.value){
            document.getElementById("form1").submit();
        } else {
            alert('Por favor, preencha as senhas com o mesmo valor, pois elas são diferentes!');
        }
        <?php } else { ?>
        document.getElementById("form1").submit();
        <?php } ?>
    }

    function excluir(){
        document.getElementById("acao").value = "E";
        document.getElementById("form1").submit();
    }

    function atualizasenha(id){
        window.location.replace('usuario_atualizasenha.php?&id='+id);
    }

    <?php if ($mensagem != "") { echo "alert('$mensagem');"; } ?>

</script>