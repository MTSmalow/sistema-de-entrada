<?php
require 'db_connect.php'; // Conexão com o banco de dados
// Definir o número máximo de notícias por página
$limite = 8; // Número de notícias por página

// Verifica a página atual, se não existir, inicia com a página 1
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina - 1) * $limite;

// Consulta para obter as notícias com LIMIT e OFFSET
$sql = "SELECT id, assunto, data FROM noticias ORDER BY data DESC LIMIT ? OFFSET ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$limite, $offset]);
$noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta para contar o total de notícias
$sql_total = "SELECT COUNT(*) FROM noticias";
$stmt_total = $pdo->prepare($sql_total);
$stmt_total->execute();
$total_noticias = $stmt_total->fetchColumn();

// Calcular o total de páginas
$total_paginas = ceil($total_noticias / $limite);
?>
