<?php

    session_start();

    include("database.php");
    $query = "SELECT * FROM corretores";
    $resultado=mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Document</title>
</head>

<body>
    <div class="texto">
        <p>Cadastro de corretor</p>
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
            <input type="submit" title="Enviar" value="Enviar">
        </div>
    </div>

    <div class="tabela">
        <table>
        
            <tr>
                <th>ID</th>
                <th>CPF</th>
                <th>Nome</th>
                <th>Creci</th>
                <th>Editar / Apagar</th>
            </tr>
            <?php while($linha = mysqli_fetch_assoc($resultado)): ?>
            <tr>
                <td><?php echo $linha['id']; ?></td>
                <td><?php echo $linha['cpf']; ?></td>
                <td><?php echo $linha['nome']; ?></td>
                <td><?php echo $linha['creci']; ?></td>
                <td><?php echo "<a href=\"editar.php?id=$linha[id]\">Editar</a> | 
			    <a href=\"deletar.php?id=$linha[id]\" onClick=\"return confirm('Você quer mesmo deletar esse corretor?')\">Deletar</a>"; ?></td>
               
            </tr>
            <?php endwhile; ?>
        </table> 

        
    </div>

</body>

</html>

<?php

    if (isset($_SESSION['confirma_edicao'])) {
        echo "<div class='msg_confirma_edicao'>" . $_SESSION['confirma_edicao'] . "</div>";
        unset($_SESSION['confirma_edicao']);
    }
    if (isset($_SESSION['confirma_delecao'])) {
        echo "<div class='msg_confirma_delecao'>" . $_SESSION['confirma_delecao'] . "</div>";
        unset($_SESSION['confirma_delecao']);
    }

    function checkCredenciais($cpf, $creci, $nome):bool {
        if(empty($cpf) || strlen($cpf) != 11) {
            return false;
        }
        if(empty($creci) || strlen($creci) < 2) {
            return false;
        }
        if(empty($nome) || strlen($nome) > 100 || preg_match('~[0-9]+~', $nome)) {
            return false;
        }
        return true;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $cpf = filter_input(INPUT_POST, "cpf", FILTER_SANITIZE_SPECIAL_CHARS);
        $creci = filter_input(INPUT_POST, "creci", FILTER_SANITIZE_SPECIAL_CHARS);
        $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);

        if (checkCredenciais($cpf, $creci, $nome)) {
            $sql = "INSERT INTO corretores (nome,cpf,creci) VALUES ('$nome','$cpf','$creci')";
            mysqli_query($conn, $sql);

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
        

    }

    mysqli_close($conn);
?>