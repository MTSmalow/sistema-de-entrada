<?php
require 'processos/db_connect.php';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

// Recupera o nome de usuário da sessão
$username = $_SESSION['username'];

// Busca o ID do usuário no banco de dados
$sql = "SELECT id FROM users WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);
$user = $stmt->fetch();

if (!$user) {
    die('Erro: Usuário não encontrado.');
}

$user_id = $user['id'];

// Verifica se já existe um registro de presença para hoje
$data_hoje = date('Y-m-d');
$sql = "SELECT * FROM presencas WHERE user_id = ? AND data = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id, $data_hoje]);
$presenca = $stmt->fetch();

if (!$presenca) {
    // Insere a presença se não houver registro para hoje
    $sql = "INSERT INTO presencas (user_id, data) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $data_hoje]);
}
?>
