<?php
require 'db_connect.php';

$limite = 3;  
// Consulta para obter as pendências pendentes
$sql = "SELECT descricao, status FROM pendencias WHERE user_id = ? AND status = 'pendente' LIMIT ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['usuario_id'], $limite]);
$pendencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
