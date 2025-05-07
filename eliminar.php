<?php
if (isset($_POST['id'])) {
    $db = new PDO("sqlite:base_dados.sqlite");
    $stmt = $db->prepare("DELETE FROM marcacoes WHERE id = :id");
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->execute();
}
header("Location: ver_marcacoes.php");
exit;
