<?php
    include("database.php");

    session_start();

    $id = $_GET['id'];

    $resultado = mysqli_query($conn, "DELETE FROM corretores WHERE id = $id");

    $_SESSION['confirma_delecao'] = "Exclusão realizada com sucesso";

    header("Location:index.php");
    exit();
?>