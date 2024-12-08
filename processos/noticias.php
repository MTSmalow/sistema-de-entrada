<?php
require 'db_connect.php'; 
$limite = 8; 

$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina - 1) * $limite;

$sql = "SELECT id, assunto, data FROM noticias ORDER BY data DESC LIMIT ? OFFSET ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$limite, $offset]);
$noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql_total = "SELECT COUNT(*) FROM noticias";
$stmt_total = $pdo->prepare($sql_total);
$stmt_total->execute();
$total_noticias = $stmt_total->fetchColumn();

$total_paginas = ceil($total_noticias / $limite);
?>
