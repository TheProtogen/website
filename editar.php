<?php
    include("database.php");

    session_start();

    $id = $_GET['id'];
?>

<html>

<head>	
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
	<title>Editar</title>
</head>

<body>
    <div class="texto">
        <p>Editar corretor</p>
    </div>

    <form class="campo_cadastro" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <div class="top">
            <input type="number" title="Digite o seu CPF" placeholder="Digite o seu CPF" name="cpf">
            <input type="number"  title="Digete o seu Creci aqui" placeholder="Digite o seu Creci" name="creci">
        </div>
        <div class="down">
            <input type="text" title="Digete o seu nome completo aqui" placeholder="Digite o seu nome" name="nome">
        </div>
        <div class="botao">
            <input type="submit" title="Atualizar cadastro" value="Atualizar cadastro">
        </div>
    </div>
</body>

</html>

<?php
    function checkCredenciais($cpf, $creci, $nome):bool {
        if(empty($cpf) || strlen($cpf) != 11) {
            return false;
        }
        if(empty($creci) || strlen($creci) < 2) {
            return false;
        }
        if(empty($nome) || strlen($creci) < 2 || preg_match('~[0-9]+~', $nome)) {
            return false;
        }
        return true;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $cpf = filter_input(INPUT_POST, "cpf", FILTER_SANITIZE_SPECIAL_CHARS);
        $creci = filter_input(INPUT_POST, "creci", FILTER_SANITIZE_SPECIAL_CHARS);
        $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);

        if (checkCredenciais($cpf, $creci, $nome)) {
            $sql = "UPDATE corretores SET `nome` = '$nome', `cpf` = '$cpf', `creci` = '$creci' WHERE `id` = $id";
            $resultado = mysqli_query($conn, $sql);

            $_SESSION['confirma_edicao'] = "Edição realizada com sucesso";

            header("Location:index.php");
            exit();
        }
        

    }
?>